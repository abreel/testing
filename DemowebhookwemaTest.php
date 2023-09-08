<?php
use App\Models\User;
use Tests\TestCase;
class VirtualAccountControllerDemowebhookwemaTest extends TestCase
{
    public function test_when_valid_request_is_made_then_200_status_code_is_returned(){
        // Call api endpoint
        $response = $this->postJson('/webhook/demo/wema', [
            'data' => [
                'name' => 'John'
            ]
        ]);
                
        // Assert response
        $response->assertStatus(200);
    }

    public function test_when_bad_request_is_made_then_400_status_code_is_returned(){
        // Call api endpoint
        $response = $this->postJson('/webhook/demo/wema', [
            'data' => []
        ]);
                
        // Assert response
        $response->assertStatus(400);
        $response->assertJsonStructure([
            'message'
        ]);
    }

    public function test_when_unauthorized_request_is_made_then_401_status_code_is_returned(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson('/webhook/demo/wema', [
            'data' => [
                'name' => 'John'
            ]
        ]);
                
        // Assert response
        $response->assertStatus(401);
        $response->assertJsonStructure([
            'message'
        ]);
    }
}