<?php

declare(strict_types=1);

namespace App\Interfaces\Http\Views;

interface ViewInterface
{
    public function render(string $template = '', array $data = []): void;
}

