<?php

namespace Tests\Unit\Infrastructure\Logging;

use PHPUnit\Framework\TestCase;
use App\Infrastructure\Logging\ConsoleLogger;

class ConsoleLoggerUnitTest extends TestCase
{
    private const string TIMESTAMP_PATTERN = '/\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\]/';

    protected function setUp(): void
    {
        parent::setUp();

        ob_start();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        ob_end_clean();
    }

    public function testInfoSuccessLogsToStdout(): void
    {
        ConsoleLogger::info('Test Info Message', ['user_id' => 42]);

        $output = ob_get_contents();

        $this->assertMatchesRegularExpression(self::TIMESTAMP_PATTERN, $output);
        $this->assertStringContainsString('INFO', $output);
        $this->assertStringContainsString('Test Info Message', $output);
        $this->assertStringContainsString('"user_id":42', $output);
    }

    public function testErrorSuccessLogsToStdout(): void
    {
        ConsoleLogger::error('Test Error Message', ['error_code' => 123]);

        $output = ob_get_contents();

        $this->assertMatchesRegularExpression(self::TIMESTAMP_PATTERN, $output);
        $this->assertStringContainsString('ERROR', $output);
        $this->assertStringContainsString('Test Error Message', $output);
        $this->assertStringContainsString('"error_code":123', $output);
    }

    public function testDebugSuccessLogsToStdout(): void
    {
        ConsoleLogger::debug('Test Debug Message', ['debug_data' => 'extra details']);

        $output = ob_get_contents();

        $this->assertMatchesRegularExpression(self::TIMESTAMP_PATTERN, $output);
        $this->assertStringContainsString('DEBUG', $output);
        $this->assertStringContainsString('Test Debug Message', $output);
        $this->assertStringContainsString('"debug_data":"extra details"', $output);
    }
}