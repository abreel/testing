<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;

class AuthControllerLogin_asTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test login as user success
     **/
    public function test_login_as_user_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson('/api/v1/login_as/' . $user->id);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $response->assertJsonStructure(['accessToken', 'refreshToken', 'userData']);
    }

    /**
     * Test login as user failure with unauthenticated user
     **/
    public function test_login_as_user_failure_unauthenticated_user()
    {
        // Create a user
        $user = User::factory()->create();

        // Call api endpoint
        $response = $this->getJson('/api/v1/login_as/' . $user->id);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson(['error' => 'Unauthenticated.']);
    }

    /**
     * Test login as user failure with bad user
     **/
    public function test_login_as_user_failure_bad_user()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson('/api/v1/login_as/12345');

        // Assert the response
        $response->assertStatus(404);
        $response->assertJson(['error' => 'User not found.']);
    }

    /**
     * Test login as user failure with bad method
     **/
    public function test_login_as_user_failure_bad_method()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson('/api/v1/login_as/' . $user->id);

        // Assert the response
        $response->assertStatus(405);
        $response->assertJson(['error' => 'Bad method.']);
    }

    /**
     * Test login as user failure with no team
     **/
    public function test_login_as_user_failure_no_team()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson('/api/v1/login_as/' . $user->id);

        // Assert the response
        $response->assertStatus(406);
        $response->assertJson(['error' => 'Team not found.']);
    }
}
