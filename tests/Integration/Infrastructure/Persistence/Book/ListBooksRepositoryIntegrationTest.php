<?php

declare(strict_types=1);

namespace Tests\Integration\Infrastructure\Persistence\Book;

use App\Domain\Book\Aggregates\BookAggregate;
use App\Infrastructure\Persistence\Book\ListBooksRepository;
use Tests\Integration\Infrastructure\Persistence\RepositoryTestCase;
use Tests\Seeders\Book\AuthorsWithBooksSeeder;

class ListBooksRepositoryIntegrationTest extends RepositoryTestCase
{
    public function testFailureReturnsEmptyArray(): void
    {
        $this->seed([
            AuthorsWithBooksSeeder::class,
        ]);

        $aggregates = (new ListBooksRepository())(6);

        $this->assertEmpty($aggregates);
    }

    public function testSuccessUsingDefaults(): void
    {
        $this->seed([
            AuthorsWithBooksSeeder::class,
        ]);

        $aggregates = (new ListBooksRepository())();

        for ($i = 0; $i < 10; ++$i) {
            $this->assertBookAggregate(AuthorsWithBooksSeeder::BOOK_DATA[$i], $aggregates[$i]);
        }
    }

    public function testSuccessUsingCustomPagination(): void
    {
        $this->seed([
            AuthorsWithBooksSeeder::class,
        ]);

        $repository = new ListBooksRepository();

        for ($page = 1; $page <= 5; $page++) {
            $aggregates = $repository($page, 2);

            for ($i = 0; $i < 2; $i++) {
                $this->assertBookAggregate(
                    AuthorsWithBooksSeeder::BOOK_DATA[($page - 1) * 2 + $i],
                    $aggregates[$i]
                );
            }
        }

        $this->assertEmpty($repository(6, 2));
    }
    
    private function assertBookAggregate(array $expected, BookAggregate $actual): void
    {
        $this->assertSame($expected['id'], $actual->getBook()->id);
        $this->assertSame($expected['name'], $actual->getBook()->name);
        $this->assertSame($expected['authorId'], $actual->getAuthor()->id);
        $this->assertSame($expected['authorName'], $actual->getAuthor()->name);
    }
}
