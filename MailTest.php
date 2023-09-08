<?php
use App\Models\User;
use Tests\TestCase;
class ControllerMailTest extends TestCase
{
    public function test_mail_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/mail");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'status' => true,
            'message' => 'Debit transaction email sent successfully'
        ]);
    }

    public function test_mail_failure()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/mail");

        // Assert the response
        $response->assertStatus(400);
        $response->assertJsonFragment([
            'status' => false,
            'message' => 'Error sending debit transaction email'
        ]);
    }

    public function test_mail_bad_validation()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/mail");

        // Assert the response
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors'
        ]);
    }
}