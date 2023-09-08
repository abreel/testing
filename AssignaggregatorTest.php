<?php
use App\Models\User;
use App\Models\Account;
use App\Models\Aggregator;
use Tests\TestCase;
class AggregatorControllerAssignaggregatorTest extends TestCase{
    public function test_assignAggregator_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        $account = Account::where('user_id', $user->id)->first();
        
        // Call api endpoint
        $response = $this->postJson("/assign/{$user->id}/{$account->id}", $account);
        
        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }

    public function test_assignAggregator_failure_no_userId(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        $account = Account::where('user_id', $user->id)->first();
        
        // Call api endpoint
        $response = $this->postJson("/assign//{$account->id}", $account);
        
        // Assert the response
        $response->assertStatus(400);
        $response->assertJson(['success' => false, 'message' => 'User ID is required']);
    }

    public function test_assignAggregator_failure_no_accountId(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        $account = Account::where('user_id', $user->id)->first();
        
        // Call api endpoint
        $response = $this->postJson("/assign/{$user->id}/", $account);
        
        // Assert the response
        $response->assertStatus(400);
        $response->assertJson(['success' => false, 'message' => 'Account ID is required']);
    }

    public function test_assignAggregator_failure_account_already_aggregator(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        $account = Account::where('user_id', $user->id)->first();

        // Create an existing aggregator
        Aggregator::create([
            'user_id' => $user->id,
            'account_id' => $account->id
        ]);
        
        // Call api endpoint
        $response = $this->postJson("/assign/{$user->id}/{$account->id}", $account);
        
        // Assert the response
        $response->assertStatus(400);
        $response->assertJson(['success' => false, 'message' => 'Account can not be an aggregator']);
    }

    public function test_assignAggregator_failure_no_account(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        $account = Account::where('user_id', $user->id)->first();

        // Set an non existing account id
        $account->id = 999;
        
        // Call api endpoint
        $response = $this->postJson("/assign/{$user->id}/{$account->id}", $account);
        
        // Assert the response
        $response->assertStatus(400);
        $response->assertJson(['success' => false, 'message' => 'Error adding aggregator']);
    }
}