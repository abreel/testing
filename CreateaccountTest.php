<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;
class AccountControllerCreateaccountTest extends TestCase
{
    use RefreshDatabase;
    public function test_create_account_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/api/v1/core/accounts", [
            'user_id' => $user->id,
            'account_type' => 'PERSONAL',
            'service_type' => 'wallet'
        ]);
            
        // Assert the response
        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Account created succesfully'
            ]);
    }

    public function test_create_account_failure_on_invalid_data()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/api/v1/core/accounts", [
            'user_id' => $user->id,
            'service_type' => 'wallet'
        ]);
            
        // Assert the response
        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function test_create_account_failure_on_invalid_userid()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/api/v1/core/accounts", [
            'user_id' => 'invalid_user_id',
            'account_type' => 'PERSONAL',
            'service_type' => 'wallet'
        ]);
            
        // Assert the response
        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
            ]);
    }
}