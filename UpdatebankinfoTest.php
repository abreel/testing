<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;
class ComplianceControllerUpdatebankinfoTest extends TestCase{
    use RefreshDatabase;

    public function test_update_bank_info_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson('/update-bank-info', [
            'status' => 'onboard-business',
            'user_id' => $user->id,
            'account_no' => '12345678',
            'account_name' => 'Test Business',
            'bank_code' => '12345',
            'slug' => 'test-bank',
            'name' => 'Test Bank',
            'display' => 'YES',
            'transaction_pin' => '1234',
            'transaction_pin_confirmation' => '1234'
        ]);
        
        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }
    
    public function test_update_bank_info_failure_due_to_invalid_data(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson('/update-bank-info', [
            'status' => 'onboard-business',
            'user_id' => $user->id,
            'account_no' => '',
            'account_name' => '',
            'bank_code' => '',
            'slug' => '',
            'name' => '',
            'display' => '',
            'transaction_pin' => '',
            'transaction_pin_confirmation' => ''
        ]);
        
        // Assert the response
        $response->assertStatus(400);
        $response->assertJson(['success' => false]);
    }
}