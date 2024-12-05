<?php

declare(strict_types=1);

namespace Database\Traits;

use PDO;

trait CanRefreshDatabase
{
    public function refreshDatabase(): void
    {
        $this->wipeDatabase()
            ->runMigrations();
    }

    public function wipeDatabase(): self
    {
        try {
            $this->getPDO()->exec("SET session_replication_role = replica;");

            $stmt = $this->getPDO()->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'");
            $tables = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($tables as $table) {
                $tableName = $table['table_name'];
                echo "Dropping table: $tableName\n";
                $this->getPDO()->exec("DROP TABLE IF EXISTS $tableName CASCADE;");
            }

            $this->getPDO()->exec("SET session_replication_role = 'origin';");

            echo "Database wiped successfully.\n";
        } catch (\PDOException $e) {
            echo "Error wiping database: " . $e->getMessage() . "\n";
        }

        return $this;
    }

    public function runMigrations($migrationDir = 'database/Migrations'): self
    {
        $migrationFiles = glob($migrationDir . '/*.php');

        sort($migrationFiles);

        foreach ($migrationFiles as $migrationFile) {
            echo "Running migration: $migrationFile\n";

            include $migrationFile;
        }

        echo "Migrations completed successfully.\n";

        return $this;
    }
}