<?php

declare(strict_types=1);

namespace App\Domain\Book\Aggregates;

use App\Domain\Book\Entities\Author;
use App\Domain\Book\Entities\Book;

class BookAggregate
{
    public function __construct(
        private Book $book,
        private Author $author
    ) {
        if ($this->book->authorId !== $this->author->id) {
            throw new \InvalidArgumentException("The book's authorId must match the author's id.");
        }
    }

    public function getBook(): Book
    {
        return $this->book;
    }

    public function getAuthor(): Author
    {
        return $this->author;
    }
}


