<?php

namespace Tests\Trait;

use Tests\Seeders\Seeder;

trait CanSeed
{
    /**
     * @param string[] $seeders
     */
    public function seed(array $seeders): void
    {
        /** @var Seeder $seeder */
        foreach ($seeders as $seeder) {
            (new $seeder())->run();
        }
    }

}
