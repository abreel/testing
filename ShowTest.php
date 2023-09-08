<?php
use App\Models\User;
use Tests\TestCase;
class ProvidersControllerShowTest extends TestCase{

    public function test_show_provider_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        $provider = Provider::factory()->create();
        
        // Call api endpoint
        $response = $this->getJson("/provider/{$provider->id}");
        
        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'contact_number',
                'address',
            ]
            'message'
        ]);
        $response->assertJsonFragment([
            'name' => $provider->name,
            'contact_number' => $provider->contact_number,
            'address' => $provider->address,
        ]);
    }

    public function test_show_provider_not_found(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->getJson("/provider/{$provider->id}");
        
        // Assert the response
        $response->assertStatus(404);
        $response->assertJsonFragment([
            'message' => 'Provider not found'
        ]);
    }
}