<?php

declare(strict_types=1);

namespace App\Domain\Book\Repositories;

use App\Domain\Book\Entities\Book;

interface ListBooksRepositoryInterface
{
    /**
     * @return Book[]
     */
    public function __invoke(): array;
}
