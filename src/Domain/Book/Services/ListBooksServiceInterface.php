<?php

declare(strict_types=1);

namespace App\Domain\Book\Services;

interface ListBooksServiceInterface
{
    public function __invoke(int $page = 1, int $limit = 10): array;
}
