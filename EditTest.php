<?php
use App\Models\User;
use App\Models\Tenant;
use Tests\TestCase;
class TenancyControllerEditTest extends TestCase
{
    public function test_user_can_edit_tenant()
    {
        // Create user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a tenant
        $tenant = Tenant::factory()->create();

        // Call the api endpoint
        $response = $this->postJson("/edit-tenant/{$tenant->id}", [
            'subdomain' => 'new-subdomain',
            'language' => 'en',
            'currency' => 'USD',
            'provider_credentials' => 'credentials',
            'package' => 'package',
            'full_domain' => 'domain',
        ]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertExactJson([
            'status' => true,
            'message' => 'Tenant Updated Successfully',
            'data' => $tenant->fresh()
        ]);
    }

    public function test_edit_tenant_fails_with_invalid_params()
    {
        // Create user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a tenant
        $tenant = Tenant::factory()->create();

        // Call the api endpoint
        $response = $this->postJson("/edit-tenant/{$tenant->id}", [
            'subdomain' => '',
            'language' => '',
            'currency' => '',
            'provider_credentials' => '',
            'package' => '',
            'full_domain' => '',
        ]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertExactJson([
            'success' => false,
            'message' => 'The subdomain field is required.',
        ]);
    }

    public function test_edit_tenant_fails_without_authentication()
    {
        // Create a tenant
        $tenant = Tenant::factory()->create();

        // Call the api endpoint
        $response = $this->postJson("/edit-tenant/{$tenant->id}", [
            'subdomain' => 'new-subdomain',
            'language' => 'en',
            'currency' => 'USD',
            'provider_credentials' => 'credentials',
            'package' => 'package',
            'full_domain' => 'domain',
        ]);

        // Assert the response
        $response->assertStatus(401);
        $response->assertExactJson([
            'error' => 'Unauthenticated',
        ]);
    }
}