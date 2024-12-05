<?php

declare(strict_types=1);

use App\Application\UseCases\Book\ImportBooksUseCase;
use App\Domain\Book\Services\FindOrStoreAuthorService;
use App\Domain\Book\Services\FindOrStoreBookService;
use App\Infrastructure\Logging\Logger;
use App\Infrastructure\Persistence\Book\CreateAuthorRepository;
use App\Infrastructure\Persistence\Book\CreateBookRepository;
use App\Infrastructure\Persistence\Book\FindAuthorByNameRepository;
use App\Infrastructure\Persistence\Book\FindBookByNameRepository;
use App\Infrastructure\Persistence\Book\UpdateBookRepository;
use App\Interfaces\Console\Command\ImportBooksCommand;
use App\Interfaces\Console\OutputBuffer;

require_once __DIR__ . '/../bootstrap.php';

$options = getopt("", ["dir:"]);

if (!isset($options['dir'])) {
    Logger::error('Error: --dir option is required.');
    exit(1);
}

$outputBuffer = new OutputBuffer();

$findAuthorByNameRepository = new FindAuthorByNameRepository();
$createAuthorRepository = new CreateAuthorRepository();
$findOrStoreAuthorService = new FindOrStoreAuthorService(
    $findAuthorByNameRepository,
    $createAuthorRepository
);

$findBookByNameRepository = new FindBookByNameRepository();
$createBookRepository = new CreateBookRepository();
$updateBookRepository = new UpdateBookRepository();

$findOrStoreBookService = new FindOrStoreBookService(
    $findBookByNameRepository,
    $createBookRepository,
    $updateBookRepository,
);

$importBooksUseCase = new ImportBooksUseCase(
    $findOrStoreAuthorService,
    $findOrStoreBookService,
);

(new ImportBooksCommand(
    $outputBuffer,
    $importBooksUseCase,
))($options['dir']);
