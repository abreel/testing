<?php
use App\Models\User;
use Tests\TestCase;

class CustomerControllerVirtualaccountdynamicTest extends TestCase
{
    public function test_valid_data_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson('/create/virtual-account/dynamic', [
            'trackingReference' => 'abc123',
        ]);

        // Assert the response
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                0 => [
                    'vbank_data' => [
                        'service_provider' => [
                            'account_reference',
                            'bank_name',
                            'acc_name',
                            'acc_number',
                            'created_on'
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function test_invalid_trackingReference_fails()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson('/create/virtual-account/dynamic', [
            'trackingReference' => '',
        ]);

        // Assert the response
        $response->assertStatus(422);
    }
}
