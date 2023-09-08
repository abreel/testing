<?php
use App\Models\User;
use Tests\TestCase;
class ComplianceControllerUpdatebusinessTest extends TestCase{
    public function test_valid_data(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $data = [
            'business_name' => 'My Business',
            'business_email' => 'info@mybusiness.com',
            'business_phone' => '1234567890',
        ];
        $response = $this->postJson("/update-business/{$user->active_merchant}", $data);
    
        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }

    public function test_invalid_data(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $data = [
            'business_name' => 'My',
            'business_email' => 'info@mybusiness',
            'business_phone' => '123',
        ];
        $response = $this->postJson("/update-business/{$user->active_merchant}", $data);
    
        // Assert the response
        $response->assertStatus(400);
        $response->assertJson(['success' => false]);
    }

    public function test_authentication_required(){
        // Call api endpoint
        $data = [
            'business_name' => 'My Business',
            'business_email' => 'info@mybusiness.com',
            'business_phone' => '1234567890',
        ];
        $response = $this->postJson("/update-business/{$user->active_merchant}", $data);

        // Assert the response
        $response->assertStatus(401);
        $response->assertJson(['success' => false, 'message' => 'Unauthenticated.']);
    }
}