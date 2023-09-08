<?php
use App\Models\User;
use Tests\TestCase;
class AclControllerListroleswithpermissionsTest extends TestCase{
    public function test_success_response(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->getJson("/api/v1/core/acl/list-roles-with-permissions");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $response->assertJsonStructure(['data' => ['roles']]);
    }

    public function test_unauthorized_response(){
        // Call api endpoint
        $response = $this->getJson("/api/v1/core/acl/list-roles-with-permissions");

        // Assert the response
        $response->assertStatus(401);
        $response->assertJson(['error' => 'Unauthorized']);
    }
}