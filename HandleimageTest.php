<?php
use App\Models\User;
use Tests\TestCase;

class ComplianceControllerHandleimageTest extends TestCase
{
    public function test_image_upload_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/api/v1/core/compliance/handle-image");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success'
        ]);
    }

    public function test_image_upload_failure()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/api/v1/core/compliance/handle-image");

        // Assert the response
        $response->assertStatus(400);
        $response->assertJsonStructure([
            'error'
        ]);
    }

    public function test_image_validation_fails()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/api/v1/core/compliance/handle-image");

        // Assert the response
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'errors'
        ]);
    }
}
