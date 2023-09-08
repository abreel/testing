<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class DocumentUploadControllerGet_uploadedTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_get_uploaded_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/core/tier-upgrade/{$user->id}");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $response->assertJsonStructure(['success', 'message', 'data' => []]);
    }

    /** @test */
    public function test_get_uploaded_fail_without_permission()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/core/tier-upgrade/{$user->id}");

        // Assert the response
        $response->assertStatus(405);
        $response->assertJson(['success' => false]);
        $response->assertJsonStructure(['success', 'message']);
    }

    /** @test */
    public function test_get_uploaded_with_status_parameter_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/core/tier-upgrade/{$user->id}?status=pending");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $response->assertJsonStructure(['success', 'message', 'data' => []]);
    }
}
