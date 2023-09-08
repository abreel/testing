<?php
use App\Models\User;
use Tests\TestCase;
class AclControllerListuserwithrolesTest extends TestCase
{
    /**
    * Test the method listUserWithRoles, when user is authenticated
    *
    * @return void
    */
    public function testListUserWithRolesAuthenticated()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/api/v1/core/acl/list-user-with-roles");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $response->assertJsonStructure(['success', 'data']);
    }

    /**
    * Test the method listUserWithRoles, when user is not authenticated
    *
    * @return void
    */
    public function testListUserWithRolesNotAuthenticated()
    {
        // Call api endpoint
        $response = $this->getJson("/api/v1/core/acl/list-user-with-roles");

        // Assert the response
        $response->assertStatus(401);
        $response->assertJson(['success' => false]);
        $response->assertJsonStructure(['success', 'message']);
    }

    /**
    * Test the method listUserWithRoles, when user_id is not found
    *
    * @return void
    */
    public function testListUserWithRolesUserIdNotFound()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/api/v1/core/acl/list-user-with-roles/0");

        // Assert the response
        $response->assertStatus(404);
        $response->assertJson(['success' => false]);
        $response->assertJsonStructure(['success', 'message']);
    }
}