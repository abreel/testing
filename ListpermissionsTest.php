<?php
use App\Models\User;
use Tests\TestCase;

class AclControllerListpermissionsTest extends TestCase
{
    public function testListPermissionsSuccess()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create Permissions
        $permissions = Permission::factory()->create();

        // Call api endpoint
        $response = $this->getJson('/api/v1/core/acl/list-permissions');

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data' => [
                '*' => [
                    'id',
                    'name'
                ]
            ]
        ]);
    }

    public function testListPermissionsFailure()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson('/api/v1/core/acl/list-permissions');

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'success' => false,
            'message' => 'No Permissions found'
        ]);
    }
}
