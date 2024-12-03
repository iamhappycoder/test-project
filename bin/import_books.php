<?php

declare(strict_types=1);

use App\Application\UseCases\Book\ImportBooksUseCase;
use App\Interfaces\Console\Command\ImportBooksCommand;
use App\Interfaces\Console\OutputBuffer;

require_once __DIR__ . '/../bootstrap.php';

$options = getopt("", ["dir:"]);

if (!isset($options['dir'])) {
    echo "Error: --dir option is required.\n";
    exit(1);
}

$outputBuffer = new OutputBuffer();
$importBooksUseCase = new ImportBooksUseCase();

(new ImportBooksCommand(
    $outputBuffer,
    $importBooksUseCase,
))($options['dir']);
