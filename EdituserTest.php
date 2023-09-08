<?php
use App\Models\User;
use Tests\TestCase;
class UserControllerEdituserTest extends TestCase
{
    public function test_edit_user_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/user/{$user->id}",[
            'first_name' => 'John',
            'last_name' => 'Doe',
            'usertype' => 'customer',
            'email' => 'john@example.com',
        ]);
        
        // Assert the response
        $response->assertOk()->assertJson([
            'success' => true,
            'message' => 'User edited successfully'
        ]);
    }
    
    public function test_edit_user_failed_validation(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/user/{$user->id}",[
            'first_name' => '',
            'last_name' => '',
            'usertype' => '',
            'email' => 'john@example',
        ]);
        
        // Assert the response
        $response->assertStatus(400)->assertJson([
            'success' => false,
            'message' => 'The email must be a valid email address.'
        ]);
    }
}