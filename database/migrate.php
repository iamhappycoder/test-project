<?php

declare(strict_types=1);

use Database\MigrationManager;

require_once __DIR__ . '/../bootstrap.php';

(new MigrationManager())
    ->refreshDatabase();