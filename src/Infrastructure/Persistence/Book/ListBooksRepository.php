<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Book;

use App\Domain\Book\Aggregates\BookAggregate;
use App\Domain\Book\Entities\Author;
use App\Domain\Book\Entities\Book;
use App\Infrastructure\Persistence\Repository;
use App\Domain\Book\Repositories\ListBooksRepositoryInterface;
use PDO;

class ListBooksRepository extends Repository implements ListBooksRepositoryInterface
{
    /**
     * @return BookAggregate[]
     */
    public function __invoke(int $page = 1, int $limit = 10): array
    {
        $sql = "
            SELECT b.id AS book_id, b.name AS book_name, a.id AS author_id, a.name AS author_name
            FROM books b
            JOIN authors a ON b.author_id = a.id
            ORDER BY b.id
            LIMIT :limit OFFSET :offset
        ";

        $offset = ($page - 1) * $limit;

        $stmt = $this->getPDO()->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function(array $row): BookAggregate{
            $book = new Book((int)$row['book_id'], $row['book_name'], (int)$row['author_id']);
            $author = new Author((int)$row['author_id'], $row['author_name']);

            return new BookAggregate($book, $author);
        }, $rows);
    }
}