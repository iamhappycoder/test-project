<?php

namespace Tests\Unit\Infrastructure\Logging;

use PHPUnit\Framework\TestCase;
use App\Infrastructure\Logging\Logger;

class ConsoleLoggerUnitTest extends TestCase
{
    private const string TIMESTAMP_PATTERN = '/\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}]/';

    public  static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        Logger::setLogFile('php://output');
    }

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
        Logger::info('Test Info Message', ['user_id' => 42]);

        $output = ob_get_contents();

        $this->assertMatchesRegularExpression(self::TIMESTAMP_PATTERN, $output);
        $this->assertStringContainsString('INFO', $output);
        $this->assertStringContainsString('Test Info Message', $output);
        $this->assertStringContainsString('"user_id":42', $output);
    }

    public function testErrorSuccessLogsToStdout(): void
    {
        Logger::error('Test Error Message', ['error_code' => 123]);

        $output = ob_get_contents();

        $this->assertMatchesRegularExpression(self::TIMESTAMP_PATTERN, $output);
        $this->assertStringContainsString('ERROR', $output);
        $this->assertStringContainsString('Test Error Message', $output);
        $this->assertStringContainsString('"error_code":123', $output);
    }

    public function testDebugSuccessLogsToStdout(): void
    {
        Logger::debug('Test Debug Message', ['debug_data' => 'extra details']);

        $output = ob_get_contents();

        $this->assertMatchesRegularExpression(self::TIMESTAMP_PATTERN, $output);
        $this->assertStringContainsString('DEBUG', $output);
        $this->assertStringContainsString('Test Debug Message', $output);
        $this->assertStringContainsString('"debug_data":"extra details"', $output);
    }
}