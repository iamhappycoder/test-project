<?php

declare(strict_types=1);

namespace App\Interfaces\Http\Controllers\Books;

use App\Interfaces\Http\Controllers\Controller;

class ListBooksController extends Controller
{
    public function __invoke(): void
    {
        $this->view->render('listBooks');
    }
}

