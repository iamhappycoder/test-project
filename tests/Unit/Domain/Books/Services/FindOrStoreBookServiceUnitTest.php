<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Books\Services;

use App\Domain\Book\Entities\Book;
use App\Domain\Book\Repositories\CreateBookRepositoryInterface;
use App\Domain\Book\Repositories\FindBookByNameRepositoryInterface;
use App\Domain\Book\Repositories\UpdateBookRepositoryInterface;
use App\Domain\Book\Services\FindOrStoreBookService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Mother\Book\BookMother;

class FindOrStoreBookServiceUnitTest extends TestCase
{
    public function testSuccessBookCreated(): void
    {
        [
            $findBookByNameRepositoryMock,
            $createBookRepositoryMock,
            $updateBookRepositoryMock,
        ] = $this->getMockObjects();

        $findBookByNameRepositoryMock->expects($this->once())->method('__invoke')
            ->with('Alice in Wonderland')
            ->willReturn(null);

        $createBookRepositoryMock->expects($this->once())->method('__invoke')
            ->with(BookMother::getSingleWithNoId())
            ->willReturnCallback(function (Book $book): void {
                $book->id = 1;
            });

        $updateBookRepositoryMock->expects($this->never())->method('__invoke');

        (new FindOrStoreBookService(
            $findBookByNameRepositoryMock,
            $createBookRepositoryMock,
            $updateBookRepositoryMock
        ))([
            'name' => 'Alice in Wonderland',
            'authorId' => 1,
        ]);
    }

    public function testSuccessBookUpdated(): void
    {
        [
            $findBookByNameRepositoryMock,
            $createBookRepositoryMock,
            $updateBookRepositoryMock,
        ] = $this->getMockObjects();

        $findBookByNameRepositoryMock->expects($this->once())->method('__invoke')
            ->with('Alice in Wonderland')
            ->willReturn(BookMother::getSingle());

        $createBookRepositoryMock->expects($this->never())->method('__invoke');

        $updateBookRepositoryMock->expects($this->once())->method('__invoke')
            ->with(BookMother::getSingleWithNewAuthor());

        (new FindOrStoreBookService(
            $findBookByNameRepositoryMock,
            $createBookRepositoryMock,
            $updateBookRepositoryMock
        ))([
            'name' => 'Alice in Wonderland',
            'authorId' => 2,
        ]);}

    /**
     * @return MockObject[]
     */
    public function getMockObjects(): array
    {
        return [
            $this->createMock(FindBookByNameRepositoryInterface::class),
            $this->createMock(CreateBookRepositoryInterface::class),
            $this->createMock(UpdateBookRepositoryInterface::class),
        ];
    }
}
