<?php

namespace Tests\Seeders;

use Database\Traits\CanGetPDO;

abstract class Seeder
{
    use CanGetPDO;

    abstract public function run(): void;
}