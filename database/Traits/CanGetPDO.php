<?php

declare(strict_types=1);

namespace Database\Traits;

use App\App;
use PDO;

trait CanGetPDO
{
    public function getPDO(): PDO
    {
        Return App::createPDO();
    }
}