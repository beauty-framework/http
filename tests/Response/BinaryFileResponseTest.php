<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Beauty\Http\Response\BinaryFileResponse;

final class BinaryFileResponseTest extends TestCase
{
    private string $tempFile;

    protected function setUp(): void
    {
        $this->tempFile = tempnam(sys_get_temp_dir(), 'testfile_');
        file_put_contents($this->tempFile, 'Hello world');
    }

    protected function tearDown(): void
    {
        @unlink($this->tempFile);
    }

    public function test_binary_file_response_sends_file(): void
    {
        $response = new BinaryFileResponse($this->tempFile);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertStringContainsString('attachment;', $response->getHeaderLine('Content-Disposition'));
        $this->assertSame('Hello world', (string)$response->getBody());
    }
}
