<?php
use App\Models\User;
    use Tests\TestCase;
    class ProviderControllerNameenquiryformobileTest extends TestCase
    {
        public function testSuccessfulNameEnquiryForMobile()
        {
            // Create a user and authenticate
            $user = User::factory()->create();
            $this->actingAs($user);
            
            // Call api endpoint
            $response = $this->postJson("/mobile-name-enquiry", ['account_no' => $user->account_no]);
    
            // Assert the response
            $response->assertStatus(200);
            $response->assertJson(['status' => true, 'message' => 'Account generated successfully', 'data' => $user->account_no]);
        }
    
        public function testFailedNameEnquiryForMobile()
        {
            // Create a user and authenticate
            $user = User::factory()->create();
            $this->actingAs($user);
            
            // Call api endpoint
            $response = $this->postJson("/mobile-name-enquiry", ['account_no' => 'invalid_account_no']);
    
            // Assert the response
            $response->assertStatus(400);
            $response->assertJson(['status' => false, 'message' => 'Account could not be verified', 'data' => null]);
        }
    }