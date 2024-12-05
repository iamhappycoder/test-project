<?php

declare(strict_types=1);

namespace Database\Migrations;

use App\App;
use PDOException;

try {
    $query = "
        CREATE TABLE authors (
            id SERIAL PRIMARY KEY,
            name VARCHAR(255) NOT NULL UNIQUE
        );
    ";

    App::createPDO()->exec($query);
    echo "Authors table created successfully.\n";
} catch (PDOException $e) {
    echo "Error creating authors table: " . $e->getMessage() . "\n";
}