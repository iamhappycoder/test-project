<?php

declare(strict_types=1);

namespace App\Infrastructure\Logging;

class Logger implements LoggerInterface
{
    private static $logFile;

    public static function setLogFile(string $logFile): void
    {
        self::$logFile = $logFile;
    }

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

        $stream = fopen(self::$logFile, 'w');
        fwrite($stream, $formattedMessage);
        fclose($stream);
    }
}
