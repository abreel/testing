<?php
use App\Models\User;
use Tests\TestCase;

class ProviderControllerGettransactionsTest extends TestCase
{
    public function test_valid_request_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson(
            '/provider/collection/transactions',
            [
                'account_reference' => $user->account_number
            ]
        );

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure(['data', 'message']);
    }

    public function test_invalid_request_validation_failure()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson(
            '/provider/collection/transactions',
            [
                'account_reference' => 12345
            ]
        );

        // Assert the response
        $response->assertStatus(422);
        $response->assertJson(
            [
                'message' => 'The given data was invalid.',
                'errors' => [
                    'account_reference' => [
                        'The account reference must exist.',
                    ],
                ],
            ]
        );
    }

    public function test_invalid_request_server_error()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson(
            '/provider/collection/transactions',
            [
                'account_reference' => $user->account_number
            ]
        );
        $this->service->shouldReceive('getCustomerAccountTransaction')->andThrow(\Exception::class);

        // Assert the response
        $response->assertStatus(500);
        $response->assertJson(
            [
                'message' => 'This service is not availabe for your provider',
            ]
        );
    }
}
