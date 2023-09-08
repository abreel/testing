<?php
use App\Models\User;
use Tests\TestCase;
class AclControllerListuserswithrolesandpermissionsTest extends TestCase
{
    public function test_list_users_with_roles_and_permissions_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->getJson('/core/acl/list-users-with-roles-and-permissions');
        
        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure(['success', 'data']);
        $this->assertTrue($response->json('success'));
    }
    
    public function test_list_users_with_roles_and_permissions_failure()
    {
        // Call api endpoint without authentication
        $response = $this->getJson('/core/acl/list-users-with-roles-and-permissions');
        
        // Assert the response
        $response->assertStatus(401);
        $response->assertJsonStructure(['message']);
    }
    
    public function test_list_users_with_roles_and_permissions_not_found()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->getJson('/core/acl/list-users-with-roles-and-permissions/999');
        
        // Assert the response
        $response->assertStatus(404);
        $response->assertJsonStructure(['message']);
    }
}