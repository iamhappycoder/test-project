<?php

namespace Tests\Unit\Domain\Books\Aggregates;

use App\Domain\Book\Aggregates\BookAggregate;
use App\Domain\Book\Entities\Author;
use App\Domain\Book\Entities\Book;
use PHPUnit\Framework\TestCase;
use Tests\Mother\Book\AuthorMother;
use Tests\Mother\Book\BookMother;

class BookAggregateUnitTest extends TestCase
{
    public function testConstructSuccess(): void
    {
        $aggregate = new BookAggregate(
            BookMother::getSingle(),
            AuthorMother::getSingle(),
        );

        $this->assertInstanceOf(Book::class, $aggregate->getBook());
        $this->assertSame(1, $aggregate->getBook()->id);
        $this->assertSame('Alice in Wonderland', $aggregate->getBook()->name);

        $this->assertInstanceOf(Author::class, $aggregate->getAuthor());
        $this->assertSame(1,$aggregate->getAuthor()->id);
        $this->assertSame('Lewis Carroll', $aggregate->getAuthor()->name);
    }
}
