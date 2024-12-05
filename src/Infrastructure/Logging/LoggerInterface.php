<?php

declare(strict_types=1);

namespace App\Infrastructure\Logging;

interface LoggerInterface
{
    public static function info(string $message, array $context = []): void;
    public static function error(string $message, array $context = []): void;
    public static function debug(string $message, array $context = []): void;
}

