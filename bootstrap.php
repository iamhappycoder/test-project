<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Infrastructure\Logging\Logger;
use Dotenv\Dotenv;

(Dotenv::createImmutable(__DIR__))->load();

Logger::setLogFile('php://output');