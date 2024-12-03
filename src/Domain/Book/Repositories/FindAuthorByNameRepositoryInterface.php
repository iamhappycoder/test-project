<?php

declare(strict_types=1);

namespace App\Domain\Book\Repositories;

use App\Domain\Book\Entities\Author;

interface FindAuthorByNameRepositoryInterface
{
    public function __invoke(string $name): ?Author;
}