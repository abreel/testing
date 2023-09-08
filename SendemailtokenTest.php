<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;
use App\Events\SendmailEvent;
use Illuminate\Support\Facades\Auth;

class ComplianceControllerSendemailtokenTest extends TestCase
{
    use RefreshDatabase;

    public function test_send_email_token_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson('/send-email-token');

        // Assert the response
        $response->assertStatus(201);
        $response->assertJson([
            'success' => true,
            'message' => 'Email Verification Token Sent'
        ]);
    }

    public function test_send_email_token_failure()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson('/send-email-token');

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => "Email Token Could not be Sent "
        ]);
    }
}