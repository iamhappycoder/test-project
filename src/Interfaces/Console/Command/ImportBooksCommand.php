<?php

declare(strict_types=1);

namespace App\Interfaces\Console\Command;

use App\Application\UseCases\Book\ImportBooksUseCase;
use App\Interfaces\Console\OutputBuffer;

class ImportBooksCommand implements ImportBookCommandInterface
{
    public function __construct(
        private readonly OutputBuffer $outputBuffer,
        private readonly ImportBooksUseCase $importBooksUseCase,
    ){
    }

    public function __invoke(string $dir): void
    {
        try {
            ($this->importBooksUseCase)($dir);
        } catch (\Throwable $exception) {
            $this->outputBuffer->append($exception->getMessage());
        }
    }
}
