<?php
use App\Models\User;
use Tests\TestCase;
class ProviderControllerCreatetransactionaccountTest extends TestCase{
    public function test_create_transaction_account_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/provider/virtual-account/generate-dynamic", [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'phone' => '08123456789',
            'email' => 'test@test.com',
            // 'transactionReference' => '00000-00000-00000-00000'
        ]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure(['data', 'message', 'status_code']);
        $this->assertEquals('success', $response['status_code']);
    }

    public function test_create_transaction_account_validation_failed(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/provider/virtual-account/generate-dynamic", [
            'firstname' => 'John',
            'lastname' => '',
            'phone' => '08123456789',
            'email' => 'test@test.com',
            // 'transactionReference' => '00000-00000-00000-00000'
        ]);

        // Assert the response
        $response->assertStatus(422);
        $response->assertJsonStructure(['message', 'errors', 'status_code']);
        $this->assertEquals('unprocessable_entity', $response['status_code']);
    }

    public function test_create_transaction_account_failed(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/provider/virtual-account/generate-dynamic", [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'phone' => '08123456789',
            'email' => 'test@test.com',
            // 'transactionReference' => '00000-00000-00000-00000'
        ]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJsonStructure(['message', 'errors', 'status_code']);
        $this->assertEquals('failed', $response['status_code']);
    }
}