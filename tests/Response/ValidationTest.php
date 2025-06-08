<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class ValidationTest extends TestCase
{
    public function test_it_validates_required_fields(): void
    {
        $validator = new \Beauty\Validation\Validator();

        $validation = $validator->make([
            'email' => null
        ], [
            'email' => ['required', 'email']
        ]);

        $validation->validate();

        $this->assertFalse($validation->passes());
        $this->assertTrue($validation->fails());
        $this->assertArrayHasKey('email', $validation->errors()->toArray());
    }

    public function test_it_passes_with_valid_input(): void
    {
        $validator = new \Beauty\Validation\Validator();

        $validation = $validator->make([
            'email' => 'user@example.com'
        ], [
            'email' => ['required', 'email']
        ]);

        $validation->validate();

        $this->assertTrue($validation->passes());
    }
}
