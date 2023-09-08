<?php
use App\Models\User;
use Tests\TestCase;
class LaravelRestHookControllerUnsubscribeTest extends TestCase{

    // Test Unsubscribe with valid request
    public function test_unsubscribe_with_valid_request(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a RestHook
        $restHook = RestHook::factory()->create([
            'user_id' => $user->id
        ]);

        // Call api endpoint
        $response = $this->postJson("/unsubscribe", [
            'id' => $restHook->id
        ]);
        
        // Assert the response
        $response->assertSuccessful();
        $response->assertJson(['Successfully unsubscribed']);
    }

    // Test Unsubscribe with invalid request
    public function test_unsubscribe_with_invalid_request(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/unsubscribe");
       
        // Assert the response
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['id']);
    }
}