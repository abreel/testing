<?php
use App\Models\User;
use App\Models\Account;
use Tests\TestCase;
class AccountControllerUpdateaccountTest extends TestCase
{
    public function test_user_update_account_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Create an account 
        $account = Account::factory()->create();
        
        // Call api endpoint
        $response = $this->postJson("/account/{$account->id}", [
            'name' => "new name",
            'account_type' => 'Test Account',
            'tier' => 'Test Tier',
            'service_type' => 'Test Service'
        ]);
        
        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Account updated succesfully'
        ]);
    }
    
    public function test_user_update_account_failure()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Create an account 
        $account = Account::factory()->create();
        
        // Call api endpoint
        $response = $this->postJson("/account/{$account->id}", [
            'name' => ""
        ]);
        
        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'The name field is required.'
        ]);
    }
    
    public function test_user_update_account_unauthorized()
    {
        // Create an account 
        $account = Account::factory()->create();
        
        // Call api endpoint
        $response = $this->postJson("/account/{$account->id}", [
            'name' => "new name",
            'account_type' => 'Test Account',
            'tier' => 'Test Tier',
            'service_type' => 'Test Service'
        ]);
        
        // Assert the response
        $response->assertStatus(401);
        $response->assertJson([
            'success' => false,
            'message' => 'Unauthenticated.'
        ]);
    }
}