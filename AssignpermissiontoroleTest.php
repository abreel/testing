<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;

class AclControllerAssignpermissiontoroleTest extends TestCase
{
    use RefreshDatabase;

    public function test_assign_permission_to_role_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create permission and role
        $permission = Permission::factory()->create();
        $role = Role::factory()->create();

        // Call api endpoint
        $response = $this->postJson("/core/acl/assign-permission-to-role", [
            'role_id' => $role->id,
            'permission' => [$permission->id]
        ]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Permissions assigned to role successfully',
        ]);
    }

    public function test_assign_permission_to_role_failed_validation()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/core/acl/assign-permission-to-role", []);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'The role id field is required.',
        ]);
    }

    public function test_assign_permission_to_role_role_not_found()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create permission
        $permission = Permission::factory()->create();

        // Call api endpoint
        $response = $this->postJson("/core/acl/assign-permission-to-role", [
            'role_id' => 999,
            'permission' => [$permission->id]
        ]);

        // Assert the response
        $response->assertStatus(404);
        $response->assertJson([
            'success' => false,
            'message' => 'Role not found',
        ]);
    }

    public function test_assign_permission_to_role_permission_not_found()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create role
        $role = Role::factory()->create();

        // Call api endpoint
        $response = $this->postJson("/core/acl/assign-permission-to-role", [
            'role_id' => $role->id,
            'permission' => [999]
        ]);

        // Assert the response
        $response->assertStatus(404);
        $response->assertJson([
            'success' => false,
            'message' => 'One or more permissions not found',
        ]);
    }
}
