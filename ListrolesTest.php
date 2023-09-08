<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;
use App\Models\Role;

class AclControllerListrolesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test List Roles successfully
     *
     * @return void
     */
    public function testListRolesSuccessfully()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/core/acl/list-roles");

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

    /**
     * Test List Roles with invalid id
     *
     * @return void
     */
    public function testListRolesWithInvalidId()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/core/acl/list-roles/1000");

        // Assert the response
        $response->assertStatus(404);
        $response->assertJsonStructure([
            'error'
        ]);
    }
}
