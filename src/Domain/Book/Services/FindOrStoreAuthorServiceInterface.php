<?php

declare(strict_types=1);

namespace App\Domain\Book\Services;

use App\Domain\Book\Entities\Author;

interface FindOrStoreAuthorServiceInterface
{
    public function __invoke(string $authorName): Author;
}
