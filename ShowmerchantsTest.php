<?php
use App\Models\User;
use Tests\TestCase;
class UserControllerShowmerchantsTest extends TestCase{
    public function test_show_merchants_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/merchants/{$user->id}");

        // Assert the response
        $response->assertStatus(200)
            ->assertJson(["success" => true])
            ->assertJsonFragment(["data" => []]);
    }

    public function test_show_merchants_failure(){
        // Call api endpoint
        $response = $this->getJson("/merchants/{$user->id}");

        // Assert the response
        $response->assertStatus(422)
            ->assertJson(["success" => false])
            ->assertJsonFragment(["message" => 'Invalid User ID.']);
    }
}