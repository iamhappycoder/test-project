<?php

namespace Tests\Integration\Infrastructure\Persistence;

use Database\Traits\CanRefreshDatabase;
use PHPUnit\Framework\TestCase;

abstract class BaseRepositoryTestCase extends TestCase
{
    use CanRefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->setPDO(getPDO())->refreshDatabase();
    }

    public function assertDatabaseContains(string $table, array $values): void
    {
        $whereClauses = [];
        foreach ($values as $column => $value) {
            $whereClauses[] = "$column = :$column";
        }
        $whereSql = implode(' AND ', $whereClauses);

        $sql = "SELECT 1 FROM $table WHERE $whereSql LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        foreach ($values as $column => $value) {
            $stmt->bindValue(":$column", $value);
        }

        $stmt->execute();

        $this->assertTrue($stmt->fetchColumn() !== false, 'Record not found');
    }
}
