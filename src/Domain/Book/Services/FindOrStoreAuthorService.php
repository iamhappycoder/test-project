<?php

declare(strict_types = 1);

namespace App\Domain\Book\Services;

use App\Domain\Book\Entities\Author;
use App\Domain\Book\Repositories\CreateAuthorRepositoryInterface;
use App\Domain\Book\Repositories\FindAuthorByNameRepositoryInterface;

class FindOrStoreAuthorService implements FindOrStoreAuthorServiceInterface
{
    public function __construct(
        private readonly FindAuthorByNameRepositoryInterface $findAuthorByNameRepository,
        private readonly CreateAuthorRepositoryInterface $createAuthorRepository,
    ) {
    }

    public function __invoke(string $authorName): Author
    {
        $author = ($this->findAuthorByNameRepository)($authorName);
        if (null === $author) {
            $author = new Author(null, $authorName);

            ($this->createAuthorRepository)($author);
        }

        return $author;
    }
}
