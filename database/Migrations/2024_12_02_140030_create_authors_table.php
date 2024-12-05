<?php

declare(strict_types=1);

namespace Database\Migrations;

use App\App;
use App\Infrastructure\Logging\Logger;
use PDOException;

try {
    $query = "
        CREATE TABLE authors (
            id SERIAL PRIMARY KEY,
            name VARCHAR(255) NOT NULL UNIQUE
        );
    ";

    App::createPDO()->exec($query);
    Logger::info('Authors table created successfully.');
} catch (PDOException $e) {
    Logger::error('Error creating authors table: ' . $e->getMessage());
}