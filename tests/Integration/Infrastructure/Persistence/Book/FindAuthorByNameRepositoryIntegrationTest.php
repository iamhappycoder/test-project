<?php

namespace Tests\Integration\Infrastructure\Persistence\Book;

use App\Infrastructure\Persistence\Book\FindAuthorByNameRepository;
use Tests\Integration\Infrastructure\Persistence\RepositoryTestCase;
use Tests\Seeders\Book\AuthorSeeder;

class FindAuthorByNameRepositoryIntegrationTest extends RepositoryTestCase
{
    public function testFailureAuthorNotFound(): void
    {
        $repository = new FindAuthorByNameRepository($this->pdo);

        $author = $repository('Nobody');

        $this->assertNull($author);
    }

    public function testSuccessAuthorFound(): void
    {
        $this->seed([
            AuthorSeeder::class,
        ]);

        $author = (new FindAuthorByNameRepository($this->pdo))('Lewis Carroll');

        $this->assertSame(1, $author->id);
        $this->assertSame('Lewis Carroll', $author->name);
    }
}