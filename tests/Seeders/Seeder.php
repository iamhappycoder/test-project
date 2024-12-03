<?php

namespace Tests\Seeders;

abstract class Seeder
{
    public function __construct(
        protected \PDO $pdo,
    ) {
    }

    abstract public function run(): void;
}