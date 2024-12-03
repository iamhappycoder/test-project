<?php

namespace Tests\Unit\Domain\Books\Services;

use App\Domain\Book\Entities\Author;
use App\Domain\Book\Services\FindOrStoreAuthorService;
use App\Infrastructure\Persistence\Book\CreateAuthorRepository;
use App\Infrastructure\Persistence\Book\FindAuthorByNameRepository;
use PHPUnit\Framework\TestCase;
use Tests\Mother\Book\AuthorMother;

class FindOrStoreAuthorServiceUnitTest extends TestCase
{
    public function testSuccessAuthorCreated(): void
    {
        $findAuthorByNameRepositoryMock = $this->createMock(FindAuthorByNameRepository::class);
        $createAuthorRepositoryMock = $this->createMock(CreateAuthorRepository::class);

        $findAuthorByNameRepositoryMock->expects($this->once())->method('__invoke')
            ->with('Lewis Carroll')
            ->willReturn(null);

        $createAuthorRepositoryMock->expects($this->once())->method('__invoke')
            ->with(AuthorMother::getSingleWithNoId())
            ->willReturnCallback(function(Author $author) {
                $author->id = 1;
            });

        $author = (new FindOrStoreAuthorService($findAuthorByNameRepositoryMock, $createAuthorRepositoryMock))(
            'Lewis Carroll',
        );

        $this->assertInstanceOf(Author::class, $author);
        $this->assertSame(1, $author->id);
        $this->assertSame('Lewis Carroll', $author->name);
    }

    public function testSuccessAuthorReturned(): void
    {
        $findAuthorByNameRepositoryMock = $this->createMock(FindAuthorByNameRepository::class);
        $createAuthorRepositoryMock = $this->createMock(CreateAuthorRepository::class);

        $findAuthorByNameRepositoryMock->expects($this->once())->method('__invoke')
            ->with('Lewis Carroll')
            ->willReturn(AuthorMother::getSingle());

        $createAuthorRepositoryMock->expects($this->never())->method('__invoke');

        $author = (new FindOrStoreAuthorService($findAuthorByNameRepositoryMock, $createAuthorRepositoryMock))(
            'Lewis Carroll',
        );

        $this->assertInstanceOf(Author::class, $author);}
}
