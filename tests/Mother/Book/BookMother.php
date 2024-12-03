<?php

declare(strict_types=1);

namespace Tests\Mother\Book;

use App\Domain\Book\Entities\Book;

class BookMother
{
    public static function getObject(
        ?int $id = null,
        string $name,
        int $authorId,
    ): Book {
        return new Book($id, $name, $authorId);
    }

    public static function getSingle(): Book
    {
        return self::getObject(1, 'Alice in Wonderland', 1);
    }

    public static function getSingleWithNoId(): Book
    {
        return self::getObject(null, 'Alice in Wonderland', 1);
    }

    public static function getSingleWithNewAuthor(): Book
    {
        return self::getObject(1, 'Alice in Wonderland', 2);
    }
}
