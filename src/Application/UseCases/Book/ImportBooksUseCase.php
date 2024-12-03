<?php

declare(strict_types=1);

namespace App\Application\UseCases\Book;

define('MAX_CONCURRENT_PROCESSES', 4); // Maximum number of concurrent processes

function glob_recursive($dir) {
    // Initialize an array to store the file paths
    $files = [];

    // Get files that match the pattern in the current directory
    $currentFiles = glob("{$dir}/*.xml");
    if ($currentFiles !== false) {
        $files = array_merge($files, $currentFiles);
    }

    // Get all subdirectories in the current directory
    $subdirs = glob("{$dir}/*", GLOB_ONLYDIR);

    // Iterate over each subdirectory and apply the function recursively
    foreach ($subdirs as $subdir) {
        $files = array_merge($files, glob_recursive($subdir, $pattern));
    }

    return $files;
}

function parseBooks($filePath) {
    $books = [];
    $xml = simplexml_load_file($filePath);

    foreach ($xml->book as $book) {
        $books[] = [
            'author' => (string) $book->author,
            'name'   => (string) $book->name,
        ];
    }

    return $books;
}

function processBooksBatch($books) {
    // Simulate processing of books (e.g., inserting to the database)
    echo "Processing batch of " . count($books) . " books...\n";

    foreach ($books as $book) {
        // Simulate book processing
        echo "Inserting book: " . $book['name'] . " by " . $book['author'] . "\n";
        // Replace with actual database insert code here
        sleep(1);  // Simulate some time for the DB insert
    }

    echo "Batch processed.\n";
}

class ImportBooksUseCase
{
    public function __invoke(string $dir): void
    {
        $booksBuffer = [];
        $taskFiles = glob_recursive($dir); // Get all XML files (adjust the path as needed)

        $runningPids = [];  // Store PIDs of running child processes

        foreach ($taskFiles as $file) {
            echo "Parsing file: $file\n";
            $books = parseBooks($file);

            foreach ($books as $book) {
                $booksBuffer[] = $book;

                // Once we have 50 books, we check if we can fork a new process
                if (count($booksBuffer) >= 50) {
                    // Wait for a child process to finish if we have too many running
                    while (count($runningPids) >= MAX_CONCURRENT_PROCESSES) {
                        // Check if any child processes have finished
                        foreach ($runningPids as $key => $pid) {
                            $status = null;
                            $result = pcntl_waitpid($pid, $status, WNOHANG);  // Non-blocking check for child process

                            if ($result == -1 || $result > 0) {
                                // If the child process has finished, remove it from the running list
                                unset($runningPids[$key]);
                            }
                        }

                        // Sleep for a short time to avoid busy-waiting
                        usleep(100000); // 100ms
                    }

                    // Fork the child process
                    $pid = pcntl_fork();

                    if ($pid == -1) {
                        die("Unable to fork.\n");
                    } elseif ($pid == 0) {
                        // Child process: process the batch of books
                        processBooksBatch($booksBuffer);
                        exit(0); // Ensure child process terminates after work
                    } else {
                        // Parent process: keep track of running child processes
                        $runningPids[] = $pid;

                        // Reset the buffer for the next batch
                        $booksBuffer = [];
                    }
                }
            }
        }

// After processing all files, check if there are any remaining books to process
        if (count($booksBuffer) > 0) {
            // Wait for a child process to finish if we have too many running
            while (count($runningPids) >= MAX_CONCURRENT_PROCESSES) {
                // Check if any child processes have finished
                foreach ($runningPids as $key => $pid) {
                    $status = null;
                    $result = pcntl_waitpid($pid, $status, WNOHANG);  // Non-blocking check for child process

                    if ($result == -1 || $result > 0) {
                        // If the child process has finished, remove it from the running list
                        unset($runningPids[$key]);
                    }
                }

                // Sleep for a short time to avoid busy-waiting
                usleep(100000); // 100ms
            }

            // Fork the final child process to process any remaining books
            $pid = pcntl_fork();

            if ($pid == -1) {
                die("Unable to fork.\n");
            } elseif ($pid == 0) {
                // Child process: process the remaining batch of books
                processBooksBatch($booksBuffer);
                exit(0); // Ensure child process terminates after work
            } else {
                // Parent process: keep track of the running child process
                $runningPids[] = $pid;
            }
        }

// After processing all files and handling the final batch, wait for any remaining child processes
        while (count($runningPids) > 0) {
            foreach ($runningPids as $key => $pid) {
                $status = null;
                $result = pcntl_waitpid($pid, $status);

                if ($result == -1 || $result > 0) {
                    // Child process has finished, remove it from the running list
                    unset($runningPids[$key]);
                }
            }
            // Sleep a little to prevent busy-waiting
            usleep(100000); // 100ms
        }

        echo "All tasks completed.\n";
    }
}