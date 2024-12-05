<?php

declare(strict_types=1);

namespace Database\Migrations;

use App\App;
use App\Infrastructure\Logging\Logger;
use PDOException;

try {
    $query = "
        CREATE TABLE books (
            id SERIAL PRIMARY KEY,
            name VARCHAR(255) NOT NULL UNIQUE,
            author_id INT NOT NULL,
            FOREIGN KEY (author_id) REFERENCES authors(id) ON DELETE CASCADE
        );
    ";

    App::createPDO()->exec($query);
    Logger::info('Books table created successfully.');
} catch (PDOException $e) {
    Logger::error('Error creating books table: ' . $e->getMessage());
}