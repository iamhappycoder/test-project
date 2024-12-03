<?php

namespace Tests\Seeders\Book;

use Tests\Mother\Book\AuthorMother;
use Tests\Seeders\Seeder;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        $author = AuthorMother::getSingle();

        $this->pdo->exec("INSERT INTO authors (id, name) VALUES ({$author->id}, '{$author->name}')");
    }
}