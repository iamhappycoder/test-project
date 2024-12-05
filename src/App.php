<?php

declare(strict_types=1);

namespace App;

use App\Infrastructure\Logging\Logger;
use PDO;
use PDOException;

class App
{
    private static ?PDO $pdo = null;

    public static function createPDO(): PDO
    {
        if (null === self::$pdo) {
            try {
                $host = $_ENV['DB_HOST'];
                $dbname = $_ENV['DB_NAME'];
                $user = $_ENV['DB_USER'];
                $password = $_ENV['DB_PASSWORD'];

                $dsn = "pgsql:host=$host;dbname=$dbname";

                self::$pdo = new PDO($dsn, $user, $password);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                Logger::info('Database connection established.');
            } catch (PDOException $e) {
                Logger::error('Database connection failed: ' . $e->getMessage());
                exit;
            }
        }

        return self::$pdo;
    }
}
