<?php

namespace Tests\Seeders\Book;

use Tests\Mother\Book\AuthorMother;
use Tests\Mother\Book\BookMother;
use Tests\Seeders\Seeder;

class AuthorWithBookSeeder extends Seeder
{
    public function run(): void
    {
        $author = AuthorMother::getSingle();
        $book = BookMother::getSingle();

        $this->pdo->exec("INSERT INTO authors (id, name) VALUES ({$author->id}, '{$author->name}')");
        $this->pdo->exec("INSERT INTO books (id, name, author_id) VALUES ({$book->id}, '{$book->name}', {$book->authorId})");
    }
}