<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Book;

use App\Domain\Book\Entities\Book;
use App\Domain\Book\Repositories\CreateBookRepositoryInterface;
use App\Infrastructure\Persistence\Repository;

class CreateBookRepository extends Repository implements CreateBookRepositoryInterface
{
    public function __invoke(Book $book): void
    {
        $sql = "INSERT INTO books (name, author_id) VALUES (:name, :author_id) RETURNING id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':name', $book->name);
        $stmt->bindValue(':author_id', $book->authorId);

        if ($stmt->execute()) {
            $book->id = $stmt->fetchColumn();
        }
    }
}
