<?php
use App\Models\User;
use Tests\TestCase;
class AclControllerAssignpermissiontouserTest extends TestCase
{
    public function test_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        $permissions = Permission::factory()->count(2)->create();

        // Call the endpoint
        $response = $this->postJson(
            '/core/acl/assign-permission-to-user',
            [
                'user_id' => $user->id,
                'permission' => $permissions->pluck('id')->toArray()
            ]
        );

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure(['success', 'message']);
        $response->assertJson(['success' => true]);
    }

    public function test_failure_bad_validation()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call the endpoint
        $response = $this->postJson(
            '/core/acl/assign-permission-to-user',
            [
                'user_id' => $user->id,
            ]
        );

        // Assert the response
        $response->assertStatus(400);
        $response->assertJsonStructure(['success', 'message']);
        $response->assertJson(['success' => false]);
    }

    public function test_failure_user_not_found()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        $permissions = Permission::factory()->count(2)->create();

        // Call the endpoint
        $response = $this->postJson(
            '/core/acl/assign-permission-to-user',
            [
                'user_id' => $user->id + 1,
                'permission' => $permissions->pluck('id')->toArray()
            ]
        );

        // Assert the response
        $response->assertStatus(404);
        $response->assertJsonStructure(['success', 'message']);
        $response->assertJson(['success' => false]);
    }

    public function test_failure_permission_not_found()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call the endpoint
        $response = $this->postJson(
            '/core/acl/assign-permission-to-user',
            [
                'user_id' => $user->id,
                'permission' => [$user->id + 1]
            ]
        );

        // Assert the response
        $response->assertStatus(404);
        $response->assertJsonStructure(['success', 'message']);
        $response->assertJson(['success' => false]);
    }
}