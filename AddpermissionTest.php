<?php
use App\Models\User;
use Tests\TestCase;

class AclControllerAddpermissionTest extends TestCase
{
    public function test_add_permission_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $data = [
            'name' => 'editPost',
            'module_id' => 1,
            'type' => 'create'
        ];
        $response = $this->postJson("/core/acl/add-permission", $data);

        // Assert the response
        $response->assertStatus(201);
        $response->assertJson(["success" => true, "message" => "Permission Created Successfully."]);
    }

    public function test_add_permission_validation_fails()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $data = [
            'module_id' => 1,
            'type' => 'create'
        ];
        $response = $this->postJson("/core/acl/add-permission", $data);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson(["success" => false, "message" => "The name field is required."]);
    }
}
