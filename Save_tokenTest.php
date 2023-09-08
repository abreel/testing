<?php
use App\Models\User;
use Tests\TestCase;
class AuthControllerSave_tokenTest extends TestCase{
    public function test_save_token_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/api/v1/save_token", [
            'token' => 'testtoken'
        ]);
 
        // Assert the response
        $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Device Token successfully saved'
        ]);
    }
 
    public function test_save_token_failure(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/api/v1/save_token", [
            'token' => ''
        ]);
 
        // Assert the response
        $response->assertStatus(400)
        ->assertJson([
            'success' => false,
            'message' => 'The token field is required.'
        ]);
    }
}