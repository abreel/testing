<?php
use App\Models\User;
use Tests\TestCase;
class ProvidersControllerIndexTest extends TestCase{
    public function test_get_providers_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->getJson("/providers/");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'email',
                    'phone',
                    'address',
                    'description',
                    'website',
                    'created_at',
                    'updated_at'
                ]
            ],
            'message',
            'status_code'
        ]);
        $response->assertJsonFragment([
            'status_code' => 200
        ]);
    }
    public function test_get_providers_failure(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->getJson("/providers/");
        $response->assertStatus(400);
        $response->assertJsonStructure([
            'data',
            'message',
            'status_code'
        ]);
        $response->assertJsonFragment([
            'status_code' => 400
        ]);
    }
    public function test_get_provider_failure_id_not_found(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->getJson("/providers/100");
        $response->assertStatus(404);
        $response->assertJsonStructure([
            'data',
            'message',
            'status_code'
        ]);
        $response->assertJsonFragment([
            'status_code' => 404
        ]);
    }
    public function test_post_provider_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/providers/", [
            'name' => 'Test Provider',
            'email' => 'test@provider.com',
            'phone' => '+123456789',
            'address' => 'Test Address',
            'description' => 'Test Description',
            'website' => 'http://testprovider.com'
        ]);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'phone',
                'address',
                'description',
                'website',
                'created_at',
                'updated_at'
            ],
            'message',
            'status_code'
        ]);
        $response->assertJsonFragment([
            'status_code' => 201
        ]);
    }
    public function test_post_provider_failure(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/providers/", [
            'name' => 'Test Provider',
            'email' => 'test@provider',
            'phone' => '+123456789',
            'address' => 'Test Address',
            'description' => 'Test Description',
            'website' => 'http://testprovider.com'
        ]);
        $response->assertStatus(400);
        $response->assertJsonStructure([
            'data',
            'message',
            'status_code'
        ]);
        $response->assertJsonFragment([
            'status_code' => 400
        ]);
    }
}