<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Providers;
use Tests\TestCase;

class ProvidersControllerUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function testUpdateProviderSuccess()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $providerId = Providers::factory()->create()->id;
        $response = $this->putJson("/provider/{$providerId}", ['name' => 'New Provider Name']);

        // Assert correct response
        $response->assertStatus(200);
        $response->assertJsonStructure(['data', 'message']);
        $response->assertJson(['message' => 'Provider Updated Successfully']);
    }

    public function testUpdateProviderFailsDueToValidationErrors()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $providerId = Providers::factory()->create()->id;
        $response = $this->putJson("/provider/{$providerId}", ['name' => '']);

        // Assert failed response
        $response->assertStatus(422);
        $response->assertJsonStructure(['message', 'errors']);
    }

    public function testUpdateProviderFailsDueToUnauthorizedUser()
    {
        // Create a user and authenticate
        $user = User::factory()->create();

        // Call api endpoint
        $providerId = Providers::factory()->create()->id;
        $response = $this->putJson("/provider/{$providerId}", ['name' => 'New Provider Name']);

        // Assert failed response
        $response->assertStatus(403);
        $response->assertJsonStructure(['message']);
    }
}
