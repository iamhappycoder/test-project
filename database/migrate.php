<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

global $pdo;

(new \Database\MigrationManager())
    ->setPDO(getPDO())
    ->refreshDatabase();