<?php
use App\Models\User;
use App\Models\Account;
use Tests\TestCase;
class ComplianceControllerVerifytransactionpinTest extends TestCase
{
    public function test_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        $account = Account::where('id', auth()->user()->active_account)->first();

        // Call api endpoint
        $response = $this->postJson("/verify-transaction-pin", ['transaction_pin' => $account->transaction_pin]);
        
        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure(['success', 'message']);
        $response->assertJson(['success' => true, 'message' => 'Transaction pin is correct']);
    }

    public function test_failure(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/verify-transaction-pin", ['transaction_pin' => 'invalid-pin']);
        
        // Assert the response
        $response->assertStatus(400);
        $response->assertJsonStructure(['success', 'message']);
        $response->assertJson(['success' => false, 'message' => 'Transaction pin is Invalid']);
    }

    public function test_bad_validation(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/verify-transaction-pin");
        
        // Assert the response
        $response->assertStatus(400);
        $response->assertJsonStructure(['success', 'message']);
        $response->assertJson(['success' => false, 'message' => 'The transaction pin field is required.']);
    }
}