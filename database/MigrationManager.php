<?php

declare(strict_types=1);

namespace Database;

require_once __DIR__ . '/../bootstrap.php';

use Database\Traits\CanGetPDO;
use Database\Traits\CanRefreshDatabase;

class MigrationManager
{
    use CanGetPDO;
    use CanRefreshDatabase;
}