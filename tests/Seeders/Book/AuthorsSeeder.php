<?php

namespace Tests\Seeders\Book;

use Tests\Mother\Book\AuthorMother;
use Tests\Seeders\Seeder;

class AuthorsSeeder extends Seeder
{
    public function run(): void
    {
        $authors = AuthorMother::getMultiple(2);

        foreach ($authors as $author) {
            $this->pdo->exec("INSERT INTO authors (id, name) VALUES ({$author->id}, '{$author->name}')");
        }

    }
}