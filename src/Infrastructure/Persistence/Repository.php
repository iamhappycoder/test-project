<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\App;

abstract class Repository
{
    public function __construct(
    ) {
    }

    public function getPDO(): \PDO
    {
        return App::createPDO();
    }
}
