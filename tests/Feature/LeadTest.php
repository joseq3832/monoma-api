<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class LeadTest extends TestCase
{
    /** @test */
    public function it_returns_lead_when_it_is_created()
    {

        $authData = [
            'username' => 'tester',
            'password' => 'PASSWORD',
        ];

        $authResponse = $this->post('/api/auth', $authData);

        $authResponse->assertStatus(200);

        $token = $authResponse->json('data.token');

        $imageData = UploadedFile::fake()->image('test-image.jpg');

        $leadData = [
            'name' => 'Mi candidato',
            'source' => $imageData,
            'owner' => 2,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/lead', $leadData);

        $response->assertStatus(200);

        $imagePath = public_path('/storage/uploads/images/test-image.jpg');

        $this->assertFileExists($imagePath);
    }

    /** @test */
    public function it_returns_unauthorized_when_creating_lead_without_authentication()
    {
        $imageData = UploadedFile::fake()->image('test-image.jpg');

        $leadData = [
            'name' => 'Mi candidato',
            'source' => $imageData,
            'owner' => 2,
        ];

        $response = $this->json('POST', '/api/lead', $leadData);

        $response->assertStatus(401)
            ->assertJson([
                'meta' => [
                    'success' => false,
                    'errors' => ['Unauthenticated.'],
                ],
            ]);
    }

    /** @test */
    public function it_returns_lead_by_id_when_authenticated()
    {
        $authData = [
            'username' => 'tester',
            'password' => 'PASSWORD',
        ];

        $authResponse = $this->post('/api/auth', $authData);

        $authResponse->assertStatus(200);

        $token = $authResponse->json('data.token');

        $leadId = 1;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('GET', "/api/lead/{$leadId}");

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'meta' => [
                'success',
                'errors',
            ],
            'data' => [
                'id',
                'name',
                'source',
                'owner',
                'created_at',
                'created_by',
            ],
        ]);
    }

    /** @test */
    public function it_returns_unauthorized_when_getting_lead_by_id_without_authentication()
    {
        $leadId = 1;

        $response = $this->json('GET', "/api/lead/{$leadId}");

        $response->assertStatus(401)
            ->assertJson([
                'meta' => [
                    'success' => false,
                    'errors' => ['Unauthenticated.'],
                ],
            ]);
    }

    /** @test */
    public function it_returns_not_found_when_getting_nonexistent_lead_by_id()
    {
        $leadId = 99999;

        $authData = [
            'username' => 'tester',
            'password' => 'PASSWORD',
        ];

        $authResponse = $this->post('/api/auth', $authData);

        $authResponse->assertStatus(200);

        $token = $authResponse->json('data.token');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('GET', "/api/lead/{$leadId}");

        $response->assertStatus(404)
            ->assertJson([
                'meta' => [
                    'success' => false,
                    'errors' => ['No lead found'],
                ],
            ]);
    }

    /** @test */
    public function it_returns_all_leads_when_authenticated_user_has_role_agent()
    {
        $authData = [
            'username' => 'agent',
            'password' => 'PASSWORD',
        ];

        $authResponse = $this->post('/api/auth', $authData);

        $authResponse->assertStatus(200);

        $token = $authResponse->json('data.token');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('GET', '/api/leads');

        $response->assertStatus(200);

        $userId = auth()->user()->id;

        $responseData = $response->json('data');

        $leadCount = count(array_filter($responseData, function ($lead) use ($userId) {
            return $lead['owner'] === $userId;
        }));

        $this->assertEquals($leadCount, count($responseData));
    }

    /** @test */
    public function it_returns_all_leads_when_authenticated_user_has_role_manager()
    {
        $authData = [
            'username' => 'tester',
            'password' => 'PASSWORD',
        ];

        $authResponse = $this->post('/api/auth', $authData);

        $authResponse->assertStatus(200);

        $token = $authResponse->json('data.token');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('GET', '/api/leads');

        $response->assertStatus(200);
    }
}
