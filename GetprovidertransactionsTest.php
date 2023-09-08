<?php
use App\Models\User;
use Tests\TestCase;
class ProvidersControllerGetprovidertransactionsTest extends TestCase
{
    public function test_get_provider_transactions_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/providers/transactions");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'provider' => [
                    'name',
                    'transactions' => [
                        '*' => [
                            'id',
                            'date',
                            'amount',
                            'type',
                            'status',
                        ]
                    ]
                ]
            ],
            'message',
            'status',
        ]);
    }

    public function test_get_provider_transactions_failure()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/providers/transactions");

        // Assert the response
        $response->assertStatus(500);
        $response->assertJsonStructure([
            'error',
            'message',
            'status'
        ]);
    }
}