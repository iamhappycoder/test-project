<?php

declare(strict_types=1);

namespace App\Interfaces\Http\Controllers;

use App\Interfaces\Http\Views\ViewInterface;

abstract class Controller
{
    public function __construct(
        protected readonly ViewInterface $view,
    ) {
    }
}
