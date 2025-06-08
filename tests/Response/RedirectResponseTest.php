<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Beauty\Http\Response\RedirectResponse;

final class RedirectResponseTest extends TestCase
{
    public function test_redirect_response_sets_location_and_status(): void
    {
        $response = new RedirectResponse('/login');

        $this->assertSame(302, $response->getStatusCode());
        $this->assertSame('/login', $response->getHeaderLine('Location'));
    }

    public function test_custom_status_code(): void
    {
        $response = new RedirectResponse('/dashboard', 301);

        $this->assertSame(301, $response->getStatusCode());
    }
}
