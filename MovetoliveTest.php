<?php
use App\Models\User;
use Tests\TestCase;
class DemoliveApiControllerMovetoliveTest extends TestCase{
    public function test_move_to_live_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/api/v1/core/user/move-to-live", [
            'user_id' => $user->id,
        ]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Merchant Onboarding Successful',
        ]);
    }

    public function test_move_to_live_failure(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/api/v1/core/user/move-to-live", [
            'user_id' => 'wrong_id',
        ]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'The selected user id is invalid.',
        ]);
    }

    public function test_move_to_live_no_id(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/api/v1/core/user/move-to-live");

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'The user id field is required.',
        ]);
    }
}