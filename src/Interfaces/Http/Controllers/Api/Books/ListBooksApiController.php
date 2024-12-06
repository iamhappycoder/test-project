<?php

declare(strict_types=1);

namespace App\Interfaces\Http\Controllers\Api\Books;

use App\Application\UseCases\Book\ListBooksUseCase;
use App\Interfaces\Http\Controllers\Controller;
use App\Interfaces\Http\Views\JSONView;

class ListBooksApiController extends Controller
{
    public function __construct(
        private readonly ListBooksUseCase $listBooksUseCase,
        private readonly JSONView $JSONView,
    ) {
        parent::__construct($this->JSONView);
    }

    public function __invoke(int $page, int $limit): void
    {
        $data = ($this->listBooksUseCase)($page, $limit);
        $this->JSONView->render('', $data);
    }
}
