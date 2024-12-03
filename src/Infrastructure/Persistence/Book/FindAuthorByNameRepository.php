<?php

namespace App\Infrastructure\Persistence\Book;

use App\Domain\Book\Entities\Author;
use App\Domain\Book\Repositories\FindAuthorByNameRepositoryInterface;
use App\Infrastructure\Persistence\Repository;
use PDO;

class FindAuthorByNameRepository extends Repository implements FindAuthorByNameRepositoryInterface
{
    public function __invoke(string $authorName): ?Author
    {
        $sql = "SELECT * FROM authors WHERE name = :name";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':name', $authorName);

        $stmt->execute();

        $author = null;

        $authorData = $stmt->fetch(PDO::FETCH_ASSOC);
        if (false !== $authorData) {
            $author = new Author(
                $authorData['id'],
                $authorData['name'],
            );
        }

        return $author;
    }
}
