<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;

class AclControllerListuserwithpermissionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_error_when_user_is_not_authenticated()
    {
        // Call api endpoint
        $response = $this->getJson("/api/v1/core/acl/list-user-with-permissions");

        // Assert the response
        $response->assertStatus(401);
        $response->assertJson(['success' => false]);
    }

    /** @test */
    public function it_returns_user_permissions_when_user_is_authenticated()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/api/v1/core/acl/list-user-with-permissions");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $response->assertJson(['data' => $user->getAllPermissions()]);
    }
}
