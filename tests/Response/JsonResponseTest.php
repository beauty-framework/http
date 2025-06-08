<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Beauty\Http\Response\JsonResponse;

final class JsonResponseTest extends TestCase
{
    public function test_it_serializes_array_data(): void
    {
        $data = ['hello' => 'world'];
        $response = new JsonResponse(200, $data);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('application/json', $response->getHeaderLine('Content-Type'));

        $this->assertJsonStringEqualsJsonString(
            json_encode($data),
            (string) $response->getBody()
        );
    }
}
