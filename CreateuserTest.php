<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;
class UserControllerCreateuserTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_user_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Post request to the api endpoint
        $response = $this->postJson("/", [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'user_type' => 'admin',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'status' => 'live'
        ]);

        // Assert the response
        $response->assertStatus(200)
        ->assertJson([
            "success" => true,
            "message" => "Account Created."
        ]);
    }

    public function test_create_user_fails_invalid_data()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Post request to the api endpoint
        $response = $this->postJson("/", [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'user_type' => 'admin',
            'email' => 'john',
            'password' => 'password',
            'password_confirmation' => 'password',
            'status' => 'live'
        ]);

        // Assert the response
        $response->assertStatus(400)
        ->assertJson([
            "success" => false,
            "message" => "The email must be a valid email address."
        ]);
    }

    public function test_create_user_fails_missing_data()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Post request to the api endpoint
        $response = $this->postJson("/", [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'user_type' => 'admin',
            'password' => 'password',
            'password_confirmation' => 'password',
            'status' => 'live'
        ]);

        // Assert the response
        $response->assertStatus(400)
        ->assertJson([
            "success" => false,
            "message" => "The email field is required."
        ]);
    }
}