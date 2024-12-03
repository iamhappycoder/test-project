<?php

declare(strict_types=1);

namespace Tests\Integration\Infrastructure\Persistence\Book;

use App\Infrastructure\Persistence\Book\CreateBookRepository;
use Tests\Integration\Infrastructure\Persistence\RepositoryTestCase;
use Tests\Mother\Book\BookMother;
use Tests\Seeders\Book\AuthorSeeder;

class CreateBookRepositoryIntegrationTest extends RepositoryTestCase
{
    public function testSuccessBookCreated(): void
    {
        $this->seed([
            AuthorSeeder::class,
        ]);

        $book = BookMother::getSingle();

        (new CreateBookRepository($this->pdo))($book);

        $this->assertDatabaseContains('books', [
            [
                'id' => 1,
                'name' => 'Alice in Wonderland',
                'author_id' => 1,
            ],
        ]);
    }
}