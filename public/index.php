<?php

declare(strict_types=1);

use App\Interfaces\Http\Controllers\Books\ListBooksController;
use App\Interfaces\Http\Views\HTMLView;

require_once __DIR__ . '/../bootstrap.php';

(new ListBooksController(
    new HTMLView()
))();
