<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Http\Request;
use Tests\TestCase;
use App\Models\Tenant;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class AuthControllerChangepasswordTest extends TestCase
{
    use RefreshDatabase;
    public function test_change_password_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        // Create a valid request
        $request = Request::create('/', 'POST', [
            'old_password' => 'password',
            'new_password' => 'password123',
            'new_password_confirmation' => 'password123'
        ]);
        // Call api endpoint
        $response = $this->postJson("/api/v1/core/general/change-password", $request->all());
        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }
    public function test_change_password_failure_invalid_old_password()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        // Create a valid request
        $request = Request::create('/', 'POST', [
            'old_password' => 'wrongpassword',
            'new_password' => 'password123',
            'new_password_confirmation' => 'password123'
        ]);
        // Call api endpoint
        $response = $this->postJson("/api/v1/core/general/change-password", $request->all());
        // Assert the response
        $response->assertStatus(400);
        $response->assertJson(['success' => false, 'message' => 'Invalid Password Provided']);
    }
    public function test_change_password_failure_invalid_validation()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        // Create a valid request
        $request = Request::create('/', 'POST', [
            'old_password' => 'password',
            'new_password' => 'pass',
            'new_password_confirmation' => 'pass'
        ]);
        // Call api endpoint
        $response = $this->postJson("/api/v1/core/general/change-password", $request->all());
        // Assert the response
        $response->assertStatus(400);
        $response->assertJson(['success' => false]);
    }
}
