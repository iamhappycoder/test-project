<?php

namespace Tests\Integration\Infrastructure\Persistence\Book;

use App\Infrastructure\Persistence\Book\FindBookByNameRepository;
use Tests\Integration\Infrastructure\Persistence\RepositoryTestCase;
use Tests\Seeders\Book\AuthorWithBookSeeder;

class FindBookByNameRepositoryIntegrationTest extends RepositoryTestCase
{
    public function testFailureBookNotFound(): void
    {
        $repository = new FindBookByNameRepository();

        $author = $repository('Alice in Wonderland');

        $this->assertNull($author);
    }

    public function testSuccessBookFound(): void
    {
        $this->seed([
            AuthorWithBookSeeder::class,
        ]);

        $book = (new FindBookByNameRepository())('Alice in Wonderland');

        $this->assertSame(1, $book->id);
        $this->assertSame('Alice in Wonderland', $book->name);
        $this->assertSame(1, $book->authorId);
    }
}
