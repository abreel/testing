<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;

class TenancyAuthControllerLoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test successful login
     *
     * @return void
     */
    public function testSuccessfulLogin()
    {
        // Create a user and authenticate
        $user = User::factory()->create();

        // Post to api endpoint
        $response = $this->postJson('/tenancy/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'userData' => [
                'email' => $user->email,
                'fullName' => $user->name,
                'id' => $user->id,
            ]
        ]);
    }

    /**
     * Test login with wrong email
     *
     * @return void
     */
    public function testLoginWithWrongEmail()
    {
        // Create a user and authenticate
        $user = User::factory()->create();

        // Post to api endpoint
        $response = $this->postJson('/tenancy/login', [
            'email' => 'wrong@email.com',
            'password' => 'password'
        ]);

        // Assert the response
        $response->assertStatus(401);
        $response->assertJson([
            'success' => false,
            'message' => 'Invalid credentials'
        ]);
    }

    /**
     * Test login with wrong password
     *
     * @return void
     */
    public function testLoginWithWrongPassword()
    {
        // Create a user and authenticate
        $user = User::factory()->create();

        // Post to api endpoint
        $response = $this->postJson('/tenancy/login', [
            'email' => $user->email,
            'password' => 'wrong-password'
        ]);

        // Assert the response
        $response->assertStatus(401);
        $response->assertJson([
            'success' => false,
            'message' => 'Invalid credentials'
        ]);
    }

    /**
     * Test login with missing fields
     *
     * @return void
     */
    public function testLoginWithMissingFields()
    {
        // Post to api endpoint
        $response = $this->postJson('/tenancy/login');

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'The email field is required.'
        ]);
    }
}
