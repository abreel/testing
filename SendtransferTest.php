<?php
use App\Models\User;
use Tests\TestCase;
class ProviderControllerSendtransferTest extends TestCase
{
    public function test_success_send_transfer(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson('/provider/transfer', [
            "accountName" => "Test Name",
            "accountNumber" => "12345678901",
            "bankname" => "Test Bank",
            "bankcode" => "123456",
            "amount" => "1000",
            "wallet_transaction_id" => "UUID123456789"
        ]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'transaction_id',
                'status',
                'date',
                'amount'
            ]
        ]);
    }

    public function test_failure_send_transfer(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson('/provider/transfer', [
            "accountName" => "Test Name",
            "accountNumber" => "12345678901",
            "bankname" => "Test Bank",
            "bankcode" => "123456",
            "amount" => "1000",
        ]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'wallet_transaction_id'
            ]
        ]);
    }

    public function test_bad_validation_send_transfer(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson('/provider/transfer', [
            "accountName" => "Test Name",
            "accountNumber" => "123",
            "bankname" => "Test Bank",
            "bankcode" => "123456",
            "amount" => "1000",
            "wallet_transaction_id" => "UUID123456789"
        ]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'accountNumber'
            ]
        ]);
    }
}