<?php

declare(strict_types=1);

namespace App\Interfaces\Console;

class OutputBuffer
{
    private array $buffer = [];

    public function append(string $message): void
    {
        $this->buffer[] = $message;
    }

    public function flush(): string
    {
        $output = implode(PHP_EOL, $this->buffer);
        $this->buffer = [];

        return $output;
    }
}
