<?php
use App\Models\User;
use Tests\TestCase;
class AclControllerRemovepermissionfromroleTest extends TestCase{
    public function test_authentication_required(){
        // Call api endpoint
        $response = $this->getJson("/api/v1/core/acl/remove-permission-from-role");
        
        // Assert the response
        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
                'message' => 'Unauthenticated.'
            ]);
    }
    
    public function test_invalid_role_id(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/api/v1/core/acl/remove-permission-from-role",['role_id'=>'invalid']);
        
        // Assert the response
        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'The given data was invalid.'
            ]);
    }
    
    public function test_role_not_found(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/api/v1/core/acl/remove-permission-from-role",['role_id'=>999]);
        
        // Assert the response
        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'Role not found'
            ]);
    }
    
    public function test_permission_not_found(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        // Create a role
        $role = Role::factory()->create();

        // Call api endpoint
        $response = $this->postJson("/api/v1/core/acl/remove-permission-from-role",['role_id'=>$role->id, 'permission'=>[999]]);
        
        // Assert the response
        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'One or more permissions not found'
            ]);
    }

    public function test_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        // Create a role and permission
        $role = Role::factory()->create();
        $permission = Permission::factory()->create();

        // Call api endpoint
        $response = $this->postJson("/api/v1/core/acl/remove-permission-from-role",['role_id'=>$role->id, 'permission'=>[$permission->id]]);
        
        // Assert the response
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Permissions removed from role successfully'
            ]);
    }
}