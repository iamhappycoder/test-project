<?php

declare(strict_types=1);

namespace Database\Migrations;

use App\App;
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
    echo "Books table created successfully.\n";
} catch (PDOException $e) {
    echo "Error creating books table: " . $e->getMessage() . "\n";
}