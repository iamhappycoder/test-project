<?php

declare(strict_types=1);

namespace App\Domain\Book\Repositories;

use App\Domain\Book\Entities\Author;

interface CreateAuthorRepositoryInterface
{
    public function __invoke(Author $author): void;
}
