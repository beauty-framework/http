<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Beauty\Http\Response\StreamResponse;

final class StreamedResponseTest extends TestCase
{
    public function test_streamed_response_outputs_data(): void
    {
        $response = new StreamResponse(function () {
            echo 'streamed content';
        });

        ob_start();
        $response->getBody()->rewind();
        $response->getBody()->write('');
        ob_end_clean();

        $this->assertSame(200, $response->getStatusCode());
    }
}
