<?php

namespace Tests\Integration\Infrastructure\Persistence;

use App\Infrastructure\Logging\Logger;
use Database\Traits\CanGetPDO;
use Database\Traits\CanRefreshDatabase;
use PHPUnit\Framework\TestCase;
use Tests\Seeders\Seeder;

abstract class RepositoryTestCase extends TestCase
{
    use CanGetPDO;
    use CanRefreshDatabase;

    public static function setUpBeforeClass(): void
    {
        Logger::setLogFile('php://temp');
    }

    public function setUp(): void
    {
        $this->refreshDatabase();
    }

    /**
     * @param string[] $seeders
     */
    public function seed(array $seeders): void
    {
        /** @var Seeder $seeder */
        foreach ($seeders as $seeder) {
           (new $seeder())->run();
       }
    }

    public function assertDatabaseContains(string $table, array $values): void
    {
        foreach ($values as $valueSet) {
            $whereClauses = [];

            foreach ($valueSet as $column => $value) {
                $whereClauses[] = "$column = :$column";
            }
            $whereSql = implode(' AND ', $whereClauses);

            $sql = "SELECT 1 FROM $table WHERE $whereSql";

            $stmt = $this->getPDO()->prepare($sql);

            foreach ($valueSet as $column => $value) {
                $stmt->bindValue(":$column", $value);
            }

            $stmt->execute();

            $this->assertTrue($stmt->fetchColumn() !== false, 'Record(s) not found');
        }
    }

}
