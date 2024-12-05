<?php

namespace Tests\Integration\Infrastructure\Persistence\Book;

use App\Infrastructure\Persistence\Book\UpdateBookRepository;
use Tests\Integration\Infrastructure\Persistence\RepositoryTestCase;
use Tests\Mother\Book\BookMother;
use Tests\Seeders\Book\AuthorsSeeder;
use Tests\Seeders\Book\BookSeeder;

class UpdateBookRepositoryIntegrationTest extends RepositoryTestCase
{
    public function testSuccessBookUpdated(): void
    {
        $this->seed([
            AuthorsSeeder::class,
            BookSeeder::class,
        ]);

        $this->assertDatabaseContains('authors', [
            [
                'id' => 1,
                'name' => 'Author 1',
            ],
            [
                'id' => 2,
                'name' => 'Author 2',
            ],
        ]);

        $this->assertDatabaseContains('books', [
            [
                'id' => 1,
                'name' => 'Alice in Wonderland',
                'author_id' => 1,
            ],
        ]);

        $book = BookMother::getSingleWithNewAuthor();

        (new UpdateBookRepository())($book);

        $this->assertDatabaseContains('books', [
            [
                'id' => 1,
                'name' => 'Alice in Wonderland',
                'author_id' => 2,
            ],
        ]);
    }
}
