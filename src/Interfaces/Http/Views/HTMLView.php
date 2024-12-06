<?php

declare(strict_types=1);

namespace App\Interfaces\Http\Views;

use App\App;

class HTMLView implements ViewInterface
{
    public function render(
        string $template = '',
        array $data = []
    ): void {
        include App::getAppDirectory() . "/src/Interfaces/Http/Templates/$template.php";
    }
}

