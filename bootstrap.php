<?php

require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

(Dotenv::createImmutable(__DIR__))->load();

function getPDO(): PDO
{
    /** @var PDO $pdo */
    static $pdo = null;

    if (null === $pdo) {
        try {
            $host = $_ENV['DB_HOST'];
            $dbname = $_ENV['DB_NAME'];
            $user = $_ENV['DB_USER'];
            $password = $_ENV['DB_PASSWORD'];

            $dsn = "pgsql:host=$host;dbname=$dbname";

            $pdo = new PDO($dsn, $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Database connection established.\n";
        } catch (PDOException $e) {
            echo "Database connection failed: " . $e->getMessage() . "\n";
            exit;
        }
    }

    return $pdo;
}