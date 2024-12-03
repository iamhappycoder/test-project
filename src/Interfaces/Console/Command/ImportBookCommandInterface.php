<?php

declare(strict_types=1);

namespace App\Interfaces\Console\Command;

interface ImportBookCommandInterface
{
    public function __invoke(string $dir): void;
}
