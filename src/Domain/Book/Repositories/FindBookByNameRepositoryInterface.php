<?php

namespace App\Domain\Book\Repositories;

use App\Domain\Book\Entities\Book;

interface FindBookByNameRepositoryInterface
{
    public function __invoke(string $name): ?Book;
}