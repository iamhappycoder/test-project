<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../bootstrap.php';

use App\Application\UseCases\Book\ListBooksUseCase;
use App\Domain\Book\Services\ListBooksService;
use App\Infrastructure\Logging\Logger;
use App\Infrastructure\Persistence\Book\ListBooksRepository;
use App\Interfaces\Http\Controllers\Api\Books\ListBooksApiController;
use App\Interfaces\Http\Views\JSONView;

Logger::setLogFile('php://temp');

$listBooksRepository = new ListBooksRepository();
$listBooksService = new ListBooksService($listBooksRepository);

(new ListBooksApiController(
    new ListBooksUseCase($listBooksService),
    new JSONView(),
))(
    (int)$_GET['page'] ?? 1,
    (int)$_GET['limit'] ?? 10
);