<?php

declare(strict_types=1);

namespace App\Infrastructure\Logging;

class ConsoleLogger implements LoggerInterface
{
    public static function info(string $message, array $context = []): void
    {
        self::log('INFO', $message, $context);
    }

    public static function error(string $message, array $context = []): void
    {
        self::log('ERROR', $message, $context);
    }

    public static function debug(string $message, array $context = []): void
    {
        self::log('DEBUG', $message, $context);
    }

    private static function log(string $level, string $message, array $context = []): void
    {
        $formattedMessage = sprintf(
            "[%s] [%s] %s %s\n",
            (new \DateTime())->format('Y-m-d H:i:s'),
            $level,
            $message,
            json_encode($context)
        );

        $stream = fopen('php://output', 'w');
        fwrite($stream, $formattedMessage);
        fclose($stream);
    }
}
