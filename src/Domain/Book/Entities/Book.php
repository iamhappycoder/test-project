<?php

declare(strict_types=1);

namespace App\Domain\Book\Entities;

class Book
{
    public function __construct(
        public ?int $id,
        public readonly string $name,
        public ?int $authorId,
    ) {
    }
}