<?php
use App\Models\User;
use Tests\TestCase;
class AclControllerAssignrolestouserTest extends TestCase{
    // Test Successful Assignment
    public function test_assign_roles_to_user_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create Roles
        $roles = Role::factory()->count(2)->create();
        $roleIds = $roles->pluck('id');

        // Call api endpoint
        $response = $this->postJson("/core/acl/assign-roles-to-user", [
            'user_id' => $user->id,
            'role' => $roleIds
        ]);

        // Assert the response
        $response->assertStatus(200)
            ->assertJson(['success' => true, 'message' => 'Roles assigned to user successfully']);
    }

    // Test Unauthenticated User
    public function test_assign_roles_to_user_unauthenticated(){
        // Create a user
        $user = User::factory()->create();

        // Create Roles
        $roles = Role::factory()->count(2)->create();
        $roleIds = $roles->pluck('id');

        // Call api endpoint
        $response = $this->postJson("/core/acl/assign-roles-to-user", [
            'user_id' => $user->id,
            'role' => $roleIds
        ]);

        // Assert the response
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    // Test Bad Validation
    public function test_assign_roles_to_user_bad_validation(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/core/acl/assign-roles-to-user", [
            'user_id' => $user->id,
            'role' => []
        ]);

        // Assert the response
        $response->assertStatus(400)
            ->assertJson(['success' => false, 'message' => 'The role field is required.']);
    }

    // Test User Not Found
    public function test_assign_roles_to_user_user_not_found(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create Roles
        $roles = Role::factory()->count(2)->create();
        $roleIds = $roles->pluck('id');

        // Call api endpoint
        $response = $this->postJson("/core/acl/assign-roles-to-user", [
            'user_id' => 9999,
            'role' => $roleIds
        ]);

        // Assert the response
        $response->assertStatus(404)
            ->assertJson(['success' => false, 'message' => 'User not found']);
    }

    // Test Role Not Found
    public function test_assign_roles_to_user_role_not_found(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create Roles
        $roleIds = [9999];

        // Call api endpoint
        $response = $this->postJson("/core/acl/assign-roles-to-user", [
            'user_id' => $user->id,
            'role' => $roleIds
        ]);

        // Assert the response
        $response->assertStatus(404)
            ->assertJson(['success' => false, 'message' => 'One or more roles not found']);
    }
}