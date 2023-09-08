<?php
use App\Models\User;
use Tests\TestCase;
class TenancyControllerListTest extends TestCase{
    public function test_list_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/tenancy/list-tenants/{$user->id}");

        // Assert the response
        $response->assertOk();
        $response->assertJson(['status' => true]);
        $response->assertJsonStructure(['status', 'data' => []]);
    }
    
    public function test_list_failure(){
        // Call api endpoint without authentication
        $response = $this->getJson("/tenancy/list-tenants");

        // Assert the response
        $response->assertStatus(401);
        $response->assertJson(['error' => 'Unautenticated']);
    }
}