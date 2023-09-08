<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;
class AuthControllerChangepassTest extends TestCase{
    use RefreshDatabase;
    public function test_change_pass_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson('/api/v1/change-pass', [
            'old_password' => 'password',
            'new_password' => 'password',
            'new_password_confirmation' => 'password',
        ]);
        
        // Assert the response
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }

    public function test_change_pass_fail()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson('/api/v1/change-pass', [
            'old_password' => 'password',
            'new_password' => 'passwor',
            'new_password_confirmation' => 'passwor',
        ]);
        
        // Assert the response
        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function test_change_pass_bad_validation()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson('/api/v1/change-pass', [
            'old_password' => 'password',
        ]);
        
        // Assert the response
        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function test_change_pass_invalid_password()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson('/api/v1/change-pass', [
            'old_password' => 'password1',
            'new_password' => 'password',
            'new_password_confirmation' => 'password',
        ]);
        
        // Assert the response
        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
            ]);
    }
}