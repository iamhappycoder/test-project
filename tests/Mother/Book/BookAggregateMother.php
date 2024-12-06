<?php

namespace Tests\Mother\Book;

use App\Domain\Book\Aggregates\BookAggregate;
use App\Domain\Book\Entities\Author;
use App\Domain\Book\Entities\Book;

class BookAggregateMother
{
    public static function getObject(Book $book, Author $author): BookAggregate
    {
        return new BookAggregate($book, $author);
    }

    public static function getSingle(): BookAggregate {
        return new BookAggregate(
            BookMother::getSingle(),
            AuthorMother::getSingle(),
        );
    }
}
