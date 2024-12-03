<?php

declare(strict_types=1);

namespace Tests\Mother\Book;

use App\Domain\Book\Entities\Author;

class AuthorMother
{
    public static function getObject(
        ?int $id,
        string $name,
    ):Author {
        return new Author($id, $name);
    }

    public static function getSingle(): Author
    {
        return self::getObject(1, 'Lewis Carroll');
    }

    public static function getSingleWithNoId(): Author
    {
        return self::getObject(null, 'Lewis Carroll');
    }

    /**
     * @return Author[]
     */
    public static function getMultiple(int $count): array
    {
        $authors = [];

        for ($i = 1; $i <= $count; $i++) {
            $authors[] = self::getObject($i, "Author {$i}");
        }

        return $authors;
    }
}
