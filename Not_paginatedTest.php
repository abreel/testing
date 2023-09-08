<?php
use App\Models\User;
use Tests\TestCase;
class ProvidersCredentialControllerNot_paginatedTest extends TestCase{
    public function test_not_paginated_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->getJson("/provider-credentials/all");
    
        // Assert the response
        $response->assertStatus(200);
        $this->assertIsArray($response->json()); 
    }

    public function test_not_paginated_failure(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->getJson("/provider-credentials/all");
    
        // Assert the response
        $response->assertStatus(404);
        $this->assertIsString($response->json()); 
    }

    public function test_not_paginated_bad_validation(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/provider-credentials/all");
    
        // Assert the response
        $response->assertStatus(422);
        $this->assertIsObject($response->json()); 
    }
}