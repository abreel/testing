<?php
use App\Models\User;
use Tests\TestCase;

class ComplianceControllerGetmerchantrecordTest extends TestCase
{
    public function test_success_response()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/merchant?userId={$user->id}");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure(['success', 'data']);
        $response->assertJsonFragment(['success' => true]);
    }

    public function test_failure_response()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/merchant?userId=null");

        // Assert the response
        $response->assertStatus(400);
        $response->assertJsonStructure(['success', 'message']);
        $response->assertJsonFragment(['success' => false]);
    }

    public function test_bad_validation()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/merchant", []);

        // Assert the response
        $response->assertStatus(422);
        $response->assertJsonStructure(['success', 'message', 'errors']);
        $response->assertJsonFragment(['success' => false]);
    }
}
