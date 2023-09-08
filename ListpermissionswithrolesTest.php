<?php
use App\Models\User;
use Tests\TestCase;

class AclControllerListpermissionswithrolesTest extends TestCase
{
    public function test_list_permissions_with_roles_unauthenticated()
    {
        // Call api endpoint
        $response = $this->getJson('/core/acl/list-permissions-with-roles');

        // Assert the response
        $response->assertStatus(401);
        $response->assertJson(['success' => false]);
    }

    public function test_list_permissions_with_roles_authenticated()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson('/core/acl/list-permissions-with-roles');

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $response->assertJsonStructure(['success', 'data' => ['permissions']]);
    }
}
