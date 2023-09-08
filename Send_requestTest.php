<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Merchant;
use Tests\TestCase;
class ComplianceControllerSend_requestTest extends TestCase
{
    use RefreshDatabase;

    public function test_send_request_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a merchant record
        $merchant = Merchant::factory()->create();

        // Call api endpoint
        $response = $this->postJson("/send-request", [
            'id' => $merchant->id
        ]);

        // Assert the response
        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'message' => 'Request succesfully sent'
        ]);
    }

    public function test_send_request_fails_without_id()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/send-request");

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'The id field is required.'
        ]);
    }

    public function test_send_request_fails_with_invalid_id()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/send-request", [
            'id' => 9999
        ]);

        // Assert the response
        $response->assertStatus(405);
        $response->assertJson([
            'success' => false,
            'message' => 'Unable to send request'
        ]);
    }
}
