<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Book;

use App\Domain\Book\Entities\Book;
use App\Infrastructure\Persistence\Repository;
use App\Domain\Book\Repositories\UpdateBookRepositoryInterface;

class UpdateBookRepository extends Repository implements UpdateBookRepositoryInterface
{
    public function __invoke(Book $book): void
    {
        $sql = "UPDATE books SET name = :name, author_id = :author_id WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $book->id);
        $stmt->bindValue(':name', $book->name);
        $stmt->bindValue(':author_id', $book->authorId);

        $stmt->execute();
    }
}