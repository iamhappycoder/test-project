<?php

declare(strict_types=1);

namespace Database;

require_once __DIR__ . '/bootstrap.php';

use Database\Traits\CanRefreshDatabase;

class MigrationManager
{
    use CanRefreshDatabase;
}