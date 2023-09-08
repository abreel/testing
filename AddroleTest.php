<?php
use App\Models\User;
use Tests\TestCase;
class AclControllerAddroleTest extends TestCase{

    public function test_add_role_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/api/v1/core/acl/add-role", ['name' => 'testname']);
        
        // Assert the response
        $response->assertStatus(201);
        $response->assertJson(["success" => true, "message" => "Role Created Successfully."]);
    }

    public function test_add_role_failure()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/api/v1/core/acl/add-role");
        
        // Assert the response
        $response->assertStatus(400);
        $response->assertJson(['success' => false, 'message' => 'The name field is required.']);
    }

    public function test_add_role_name_already_exists()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/api/v1/core/acl/add-role", ['name' => 'testname']);
        
        // Assert the response
        $response->assertStatus(400);
        $response->assertJson(['success' => false, 'message' => 'The name has already been taken.']);
    }
}