<?php

declare(strict_types=1);

namespace App\Application\UseCases\Book;

use App\Domain\Book\Services\FindOrStoreAuthorServiceInterface;
use App\Domain\Book\Services\FindOrStoreBookServiceInterface;
use App\Infrastructure\Logging\Logger;

class ImportBooksUseCase
{
    private array $childPIDs;

    public function __construct(
        private readonly FindOrStoreAuthorServiceInterface $findOrStoreAuthorService,
        private readonly FindOrStoreBookServiceInterface $findOrStoreBookService,
    ) {
        $this->childPIDs = [];
    }

    public function __invoke(
        string $dir,
        $maxConcurrentProcesses = 1,
    ): void {
        $xmlFiles = $this->getXMLFiles($dir);

        foreach ($xmlFiles as $xmlFile) {
            Logger::info("Parsing file: $xmlFile");
            $books = $this->parseXMLFile($xmlFile);
            $this->waitForChildProcesses($maxConcurrentProcesses);
            $this->forkChildProcess($books);
        }

        // After processing all files and handling the final batch, wait for any remaining child processes
        $this->waitForChildProcesses();
    }

    /**
     * @return string[]
     */
    private function getXMLFiles(string $dir): array
    {
        $xmlFiles = [];

        // Get list of XML files.
        $currentFiles = glob("{$dir}/*.xml");
        if ($currentFiles !== false) {
            $xmlFiles = array_merge($xmlFiles, $currentFiles);
        }

        // Get list of directories.
        $subdirs = glob("{$dir}/*", GLOB_ONLYDIR);

        foreach ($subdirs as $subdir) {
            $xmlFiles = array_merge($xmlFiles, $this->getXMLFiles($subdir));
        }

        return $xmlFiles;
    }

    /**
     * @return array[]
     */
    private function parseXMLFile($xmlFile): array
    {
        $books = [];
        $xml = simplexml_load_file($xmlFile);

        foreach ($xml->book as $book) {
            $books[] = [
                'author' => (string) $book->author,
                'name'   => (string) $book->name,
            ];
        }

        return $books;
    }

    /**
     * Wait for child processes to fall below $targetChildCount.
     */
    private function waitForChildProcesses(int $targetChildCount = 1): void
    {
        while (count($this->childPIDs) >= $targetChildCount) {
            foreach ($this->childPIDs as $key => $pid) {
                $status = 0;
                $result = pcntl_waitpid($pid, $status, WNOHANG);

                // Child process is no longer running, don't care about exit status for now.
                if ($result == -1 || $result > 0) {
                    unset($this->childPIDs[$key]);
                }
            }

            // Sleep for a short time to avoid busy-waiting
            usleep(100000); // 100ms
        }
    }

    private function forkChildProcess(array $books): void
    {
        $pid = pcntl_fork();

        if ($pid == -1) {
            // Gracefully exit.
            return;
        } elseif ($pid == 0) {
            //
            // Child process.
            //
            $exitStatus = 0;
            try {
                $this->storeBooks($books);
            } catch (\Throwable $exception) {
                $exitStatus = $exception->getCode();

                Logger::info('An exception occurred: ' . $exception->getMessage());
            }

            exit($exitStatus);
        } else {
            //
            // Parent process.
            //
            $this->childPIDs[] = $pid;
        }
    }


    private function storeBooks(array $books): void
    {
        foreach ($books as $book) {
            $author = ($this->findOrStoreAuthorService)($book['author']);

            $book['authorId'] = $author->id;
            ($this->findOrStoreBookService)($book);
        }
    }
}