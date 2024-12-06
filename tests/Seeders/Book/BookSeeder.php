<?php

namespace Tests\Seeders\Book;

use Tests\Mother\Book\BookMother;
use Tests\Seeders\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $book = BookMother::getSingle();

        $this->getPDO()->exec("INSERT INTO books (id, name, author_id) VALUES ({$book->id}, '{$book->name}', {$book->authorId})");
    }
}
