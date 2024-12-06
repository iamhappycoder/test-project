<?php

declare(strict_types=1);

namespace App\Application\UseCases\Book;

use App\Domain\Book\Services\ListBooksServiceInterface;

class ListBooksUseCase
{
    public function __construct(
        private readonly ListBooksServiceInterface $listBooksService,
    ) {
    }

    public function __invoke(int $page = 1, int $limit = 10): array
    {
        return ($this->listBooksService)($page, $limit);
    }
}
