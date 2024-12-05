<?php

namespace Tests\Integration\Infrastructure\Persistence\Book;

use App\Infrastructure\Persistence\Book\CreateAuthorRepository;
use Tests\Integration\Infrastructure\Persistence\RepositoryTestCase;
use Tests\Mother\Book\AuthorMother;

class CreateAuthorRepositoryIntegrationTest extends RepositoryTestCase
{
    public function testSuccessAuthorCreated(): void
    {
        $author = AuthorMother::getSingle();

        (new CreateAuthorRepository())($author);

        $this->assertDatabaseContains('authors', [
            [
                'id' => 1,
                'name' => 'Lewis Carroll',
            ],
        ]);
    }
}
