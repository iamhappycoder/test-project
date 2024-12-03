<?php

declare(strict_types=1);

namespace App\Domain\Book\Repositories;

use App\Domain\Book\Entities\Book;

interface UpdateBookRepositoryInterface
{
    public function __invoke(Book $book): void;
}
