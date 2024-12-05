<?php

declare(strict_types=1);

namespace Database\Traits;

use App\Infrastructure\Logging\Logger;
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
                Logger::info('Dropping table: $tableName');
                $this->getPDO()->exec("DROP TABLE IF EXISTS $tableName CASCADE;");
            }

            $this->getPDO()->exec("SET session_replication_role = 'origin';");

            Logger::info( 'Database wiped successfully.');
        } catch (\PDOException $e) {
            Logger::error('Error wiping database: " . $e->getMessage()');
        }

        return $this;
    }

    public function runMigrations($migrationDir = 'database/Migrations'): self
    {
        $migrationFiles = glob($migrationDir . '/*.php');

        sort($migrationFiles);

        foreach ($migrationFiles as $migrationFile) {
            Logger::info("Running migration: $migrationFile");

            include_once $migrationFile;
        }

        Logger::info('Migrations completed successfully.');

        return $this;
    }
}