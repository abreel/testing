<?php
use App\Models\User;
use Tests\TestCase;
class BeneficiaryControllerRevertbeneficiaryfavouriteTest extends TestCase{
    
    public function test_revert_beneficiary_favourite_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/api/v1/banking/beneficiary/remove-from-favourite", ['id'=> 1]);
        
        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['success'=>true]);
    }
    
    public function test_revert_beneficiary_favourite_bad_request(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/api/v1/banking/beneficiary/remove-from-favourite", ['foo'=> 'bar']);
        
        // Assert the response
        $response->assertStatus(400);
        $response->assertJson(['success'=>false]);
    }
    
    public function test_revert_beneficiary_favourite_fails_with_exception(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/api/v1/banking/beneficiary/remove-from-favourite", ['id' => 1]);
        
        // Assert the response
        $response->assertStatus(500);
        $response->assertJson(['success'=>false]);
    }
}