<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;
use App\Models\Provider;

class ProvidersControllerDestroyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_tests_for_successful_deletion()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Create a provider
        $provider = Provider::factory()->create();

        // Call api endpoint
        $response = $this->deleteJson("/providers/{$provider->id}");
        
        // Assert the response
        $response->assertOk();
        $response->assertJson(['data' => 'Provider Deleted Successfully']);
    }

    /** @test */
    public function it_tests_for_failure_when_provider_not_found()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->deleteJson("/providers/99999");
        
        // Assert the response
        $response->assertNotFound();
        $response->assertJson(['message' => 'Provider not found']);
    }

    /** @test */
    public function it_tests_for_unauthorized_access()
    {
        // Create a provider
        $provider = Provider::factory()->create();

        // Call api endpoint
        $response = $this->deleteJson("/providers/{$provider->id}");
        
        // Assert the response
        $response->assertUnauthorized();
        $response->assertJson(['message' => 'Unauthenticated.']);
    }
}