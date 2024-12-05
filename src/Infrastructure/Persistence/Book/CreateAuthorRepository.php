<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Book;

use App\Domain\Book\Entities\Author;
use App\Domain\Book\Repositories\CreateAuthorRepositoryInterface;
use App\Infrastructure\Persistence\Repository;

class CreateAuthorRepository extends Repository implements CreateAuthorRepositoryInterface
{
    public function __invoke(Author $author): void
    {
        $sql = "INSERT INTO authors (name) VALUES (:name) RETURNING id";

        $stmt = $this->getPDO()->prepare($sql);
        $stmt->bindValue(':name', $author->name);

        if ($stmt->execute()) {
            $author->id = $stmt->fetchColumn();
        }
    }
}