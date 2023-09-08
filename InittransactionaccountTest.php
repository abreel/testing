<?php
use App\Models\User;
use Tests\TestCase;
class ProviderControllerInittransactionaccountTest extends TestCase
{
    public function test_init_transaction_account_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/virtual/account/init/transaction", ['transid' => $user->transid]);
        
        // Assert the response
        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function test_init_transaction_account_fails_with_invalid_transid()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/virtual/account/init/transaction", ['transid' => '1111111111']);
        
        // Assert the response
        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function test_init_transaction_account_fails_with_missing_transid()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/virtual/account/init/transaction");
        
        // Assert the response
        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function test_init_transaction_account_fails_with_service_not_available()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/virtual/account/init/transaction", ['transid' => $user->transid]);
        
        // Assert the response
        $response->assertStatus(500)
            ->assertJsonStructure([
                'message',
            ]);
    }
}