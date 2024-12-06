<?php

declare(strict_types=1);

namespace App\Interfaces\Http\Views;

class JSONView implements ViewInterface
{
    public function render(string $template = '', array $data = []): void
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}