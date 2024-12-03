<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

abstract class Repository
{
    public function __construct(
        protected readonly \PDO $pdo,
    ) {
    }
}
