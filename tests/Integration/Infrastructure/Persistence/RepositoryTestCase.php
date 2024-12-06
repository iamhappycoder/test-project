<?php

namespace Tests\Integration\Infrastructure\Persistence;

use App\Infrastructure\Logging\Logger;
use Database\Traits\CanGetPDO;
use Database\Traits\CanRefreshDatabase;
use PHPUnit\Framework\TestCase;
use Tests\Seeders\Seeder;
use Tests\Trait\CanSeed;

abstract class RepositoryTestCase extends TestCase
{
    use CanGetPDO;
    use CanRefreshDatabase;
    use CanSeed;

    public static function setUpBeforeClass(): void
    {
        Logger::setLogFile('php://temp');
    }

    public function setUp(): void
    {
        $this->refreshDatabase();
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
