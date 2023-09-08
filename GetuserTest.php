<?php
use App\Models\User;
use Tests\TestCase;
class DemoliveApiControllerGetuserTest extends TestCase{

    public function test_getUser_with_valid_userId()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->getJson("/api/v1/core/user/api-request", ['user_id' => $user->id]);
        
        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'user' => [
                'first_name',
                'last_name',
                'usertype',
                'active_merchant',
                'email',
                'phone',
                'bvn'
            ],
            'user_password',
            'settlement_bank' => [
                'bank_code',
                'account_no',
                'account_name',
                'name',
                'bank_name',
                'settlement_email'
            ],
            'merchant' => [
                'business_name'
            ]
        ]);
        $response->assertJson([
            'success' => true,
            'message' => 'Merchant Onboarding Successful',
        ]);
    }
    
    public function test_getUser_with_invalid_userId()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->getJson("/api/v1/core/user/api-request", ['user_id' => "invalidID"]);
        
        // Assert the response
        $response->assertStatus(422);
        $response->assertJson([
            'success' => false,
            'message' => 'The user id must be a number.',
        ]);
    }
    
    public function test_getUser_with_no_userId()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->getJson("/api/v1/core/user/api-request");
        
        // Assert the response
        $response->assertStatus(422);
        $response->assertJson([
            'success' => false,
            'message' => 'The user id field is required.',
        ]);
    }
    
    public function test_getUser_with_invalid_parameters()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->getJson("/api/v1/core/user/api-request", ['user_id' => $user->id, 'invalid_param' => 'invalid_value']);
        
        // Assert the response
        $response->assertStatus(422);
        $response->assertJson([
            'success' => false,
            'message' => 'The given data was invalid.'
        ]);
    }
    
    public function test_getUser_with_unauthorized_access()
    {
        // Call api endpoint
        $response = $this->getJson("/api/v1/core/user/api-request");
        
        // Assert the response
        $response->assertStatus(401);
        $response->assertJson([
            'success' => false,
            'message' => 'Unauthenticated.'
        ]);
    }
}