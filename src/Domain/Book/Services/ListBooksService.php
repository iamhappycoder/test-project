<?php

declare(strict_types = 1);

namespace App\Domain\Book\Services;

use App\Infrastructure\Persistence\Book\ListBooksRepository;

class ListBooksService implements ListBooksServiceInterface
{
    public function __construct(
       private readonly ListBooksRepository $listBooksRepository,
    ) {
    }

    public function __invoke(int $page = 1, int $limit = 10): array
    {
        $data = [];

        $bookAggregates = ($this->listBooksRepository)($page, $limit);
        foreach ($bookAggregates as $bookAggregate) {
            $data[] = [
                'name' => $bookAggregate->getBook()->name,
                'author_name' => $bookAggregate->getAuthor()->name,
            ];
        }

        return $data;
    }
}
