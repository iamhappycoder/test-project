<?php

declare(strict_types=1);

namespace App\Domain\Book\Services;

use App\Domain\Book\Entities\Book;
use App\Domain\Book\Repositories\CreateBookRepositoryInterface;
use App\Domain\Book\Repositories\FindBookByNameRepositoryInterface;
use App\Domain\Book\Repositories\UpdateBookRepositoryInterface;

class FindOrStoreBookService implements FindOrStoreBookServiceInterface
{
    public function __construct(
        private readonly FindBookByNameRepositoryInterface $findBookByNameRepository,
        private readonly CreateBookRepositoryInterface $createBookRepository,
        private readonly UpdateBookRepositoryInterface $updateBookRepository,
    ) {
    }

    public function __invoke(array $data): Book
    {
        $book = ($this->findBookByNameRepository)($data['name']);
        if (null === $book) {
            $book = new Book(
                null,
                $data['name'],
                $data['authorId'],
            );

            ($this->createBookRepository)($book);
        } else {
            $book->authorId = $data['authorId'];
            ($this->updateBookRepository)($book);
        }

        return $book;
    }
}
