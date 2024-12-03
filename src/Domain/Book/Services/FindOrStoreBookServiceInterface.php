<?php

declare(strict_types=1);

namespace App\Domain\Book\Services;

use App\Domain\Book\Entities\Book;

interface FindOrStoreBookServiceInterface
{
    public function __invoke(array $data): Book;
}
