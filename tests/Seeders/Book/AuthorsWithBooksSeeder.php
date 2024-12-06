<?php


namespace Tests\Seeders\Book;

use Tests\Seeders\Seeder;

class AuthorsWithBooksSeeder extends Seeder
{
    public const array BOOK_DATA = [
        ['id' => 1, 'name' => 'To Kill a Mockingbird', 'authorId' => 1, 'authorName' => 'Harper Lee'],
        ['id' => 2, 'name' => 'Sapiens', 'authorId' => 2, 'authorName' => 'Yuval Noah Harari'],
        ['id' => 3, 'name' => 'The Hobbit', 'authorId' => 3, 'authorName' => 'J.R.R. Tolkien'],
        ['id' => 4, 'name' => 'A Brief History of Time', 'authorId' => 4, 'authorName' => 'Stephen Hawking'],
        ['id' => 5, 'name' => 'Guns, Germs, and Steel', 'authorId' => 5, 'authorName' => 'Jared Diamond'],
        ['id' => 6, 'name' => '1984', 'authorId' => 6, 'authorName' => 'George Orwell'],
        ['id' => 7, 'name' => 'The Selfish Gene', 'authorId' => 7, 'authorName' => 'Richard Dawkins'],
        ['id' => 8, 'name' => 'The Pillars of the Earth', 'authorId' => 8, 'authorName' => 'Ken Follett'],
        ['id' => 9, 'name' => 'A Short History of Nearly Everything', 'authorId' => 9, 'authorName' => 'Bill Bryson'],
        ['id' => 10, 'name' => 'The Alchemist', 'authorId' => 10, 'authorName' => 'Paulo Coelho']
    ];

    public function run(): void
    {
        foreach (self::BOOK_DATA as $book) {
            try {
                $this->getPDO()->exec(sprintf("INSERT INTO authors (id, name) VALUES (%d, '%s')", $book['authorId'], $book['authorName']));
                $this->getPDO()->exec(sprintf("INSERT INTO books (id, name, author_id) VALUES (%d, '%s', %d)", $book['id'], $book['name'], $book['authorId']));
            } catch (\Throwable $exception) {
                var_dump($exception->getMessage());
            }
        }

    }
}
