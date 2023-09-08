<?php
use App\Models\User;
use Tests\TestCase;
class CreateTest extends TestCase
{
    public function test_create_tenant_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/api/tenancy/create-tenant", [
            'subdomain' => 'tenant1',
            'language' => 'en',
            'currency' => 'USD',
            'provider_credentials' => 'xxxxxx',
            'package' => 'small',
            'full_domain' => 'tenant1.example.com'
        ]);
    
        // Assert the response
        $response->assertStatus(201);
        $response->assertJson(['message' => 'subdomain successfully created']);
    }

    public function test_create_tenant_failure()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/api/tenancy/create-tenant", [
            'subdomain' => '',
            'language' => 'en',
            'currency' => 'USD',
            'provider_credentials' => 'xxxxxx',
            'package' => 'small',
            'full_domain' => 'tenant1.example.com'
        ]);
    
        // Assert the response
        $response->assertStatus(400);
        $response->assertJson(['success' => false, 'message' => 'The subdomain field is required.']);
    }

    public function test_create_tenant_unauthenticated()
    {
        // Call api endpoint
        $response = $this->postJson("/api/tenancy/create-tenant", [
            'subdomain' => 'tenant1',
            'language' => 'en',
            'currency' => 'USD',
            'provider_credentials' => 'xxxxxx',
            'package' => 'small',
            'full_domain' => 'tenant1.example.com'
        ]);
        
        // Assert the response
        $response->assertStatus(401);
        $response->assertJson(['error' => 'Unautenticated']);
    }
}