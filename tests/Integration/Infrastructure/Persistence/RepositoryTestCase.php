<?php

namespace Tests\Integration\Infrastructure\Persistence;

use Database\Traits\CanRefreshDatabase;
use PHPUnit\Framework\TestCase;
use Tests\Seeders\Seeder;

abstract class RepositoryTestCase extends TestCase
{
    use CanRefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->setPDO(getPDO())->refreshDatabase();
    }

    /**
     * @param string[] $seeders
     */
    public function seed(array $seeders): void
    {
        /** @var Seeder $seeder */
        foreach ($seeders as $seeder) {
           (new $seeder($this->pdo))->run();
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

            $stmt = $this->pdo->prepare($sql);

            foreach ($valueSet as $column => $value) {
                $stmt->bindValue(":$column", $value);
            }

            $stmt->execute();

            $this->assertTrue($stmt->fetchColumn() !== false, 'Record(s) not found');
        }
    }

}
