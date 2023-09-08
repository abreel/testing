<?php
use App\Models\User;
use Tests\TestCase;
class ComplianceControllerUpdatewebhookapiTest extends TestCase{
    public function test_updateWebhookApi_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $data = [
            'webhook' => 'https://example.com/webhook',
            'token' => 'token123',
        ];
        $response = $this->postJson("/updateWebhookApi", $data);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['success' => true, 'message' => 'Webhook api updated successfully']);
    }

    public function test_updateWebhookApi_bad_validation(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $data = [
            'webhook' => 'https://example.com/webhook',
        ];
        $response = $this->postJson("/updateWebhookApi", $data);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson(['success' => false, 'message' => 'The token field is required.']);
    }

    public function test_updateWebhookApi_cant_find_merchant(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $data = [
            'webhook' => 'https://example.com/webhook',
            'token' => 'token123',
        ];
        $response = $this->postJson("/updateWebhookApi", $data);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson(['success' => false, 'message' => 'Cant find merchant']);
    }
}