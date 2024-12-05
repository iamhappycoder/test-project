<?php

declare(strict_types = 1);

namespace App\Infrastructure\Persistence\Book;

use App\Domain\Book\Entities\Book;
use App\Domain\Book\Repositories\FindBookByNameRepositoryInterface;
use App\Infrastructure\Persistence\Repository;
use PDO;

class FindBookByNameRepository extends Repository implements FindBookByNameRepositoryInterface
{
    function __invoke(string $bookName): ?Book
    {
        $sql = "SELECT * FROM books WHERE name = :name LIMIT 1";

        $stmt = $this->getPDO()->prepare($sql);

        $stmt->bindValue(':name', $bookName);

        $stmt->execute();

        $book = null;

        $bookData = $stmt->fetch(PDO::FETCH_ASSOC);
        if (false !== $bookData) {
            $book = new Book(
                $bookData['id'],
                $bookData['name'],
                $bookData['author_id']
            );
        }

        return $book;
    }
}
