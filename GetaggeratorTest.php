<?php
use App\Models\User;
use Tests\TestCase;
class WalletControllerGetaggeratorTest extends TestCase{
    public function test_get_aggerator_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->getJson("/banking/aggerator");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure(["data" => [
            "id",
            "name",
            "description"
        ]]);
    }

    public function test_get_aggerator_unauthorized(){
        // Call api endpoint
        $response = $this->getJson("/banking/aggerator");

        // Assert the response
        $response->assertStatus(401);
    }
}