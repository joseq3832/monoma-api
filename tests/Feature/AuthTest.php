<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthTest extends TestCase
{
    /** @test */
    public function it_returns_a_token_when_credentials_are_correct()
    {
        $data = [
            'username' => 'tester',
            'password' => 'PASSWORD',
        ];

        $response = $this->post('/api/auth', $data);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'meta' => [
                'success',
                'errors',
            ],
            'data' => [
                'token',
                'minutes_to_expire',
            ],
        ]);

        $response->assertJson(['meta' => ['success' => true]]);

        $response->assertJson(['data' => ['token' => true]]);
    }

    /** @test */
    public function it_returns_unauthorized_when_credentials_are_incorrect()
    {
        $data = [
            'username' => 'tester',
            'password' => 'incorrect_password',
        ];

        $response = $this->post('/api/auth', $data);

        $response->assertStatus(401);

        $response->assertJsonStructure([
            'meta' => [
                'success',
                'errors',
            ],
        ]);

        $response->assertJson(['meta' => ['success' => false]]);

        $response->assertJson(['meta' => ['errors' => ['Password incorrect for: tester']]]);
    }
}
