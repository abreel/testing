<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class TenancyAuthControllerRegisterTest extends TestCase{
    use RefreshDatabase;
    public function test_successful_registration(){
        // Call api endpoint
        $response = $this->postJson("/tenancy/register", [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'password'
        ]);

        // Assert the response
        $response->assertStatus(201);
        $response->assertJson([
            'success' => true,
            'message' => 'Account Created Successfully.'
        ]);
    }
    
    public function test_registration_bad_data_validation(){
        // Call api endpoint
        $response = $this->postJson("/tenancy/register", [
            'name' => 'John Doe',
            'email' => 'john.doeexample.com',
            'password' => 'pass'
        ]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'The email must be a valid email address.'
        ]);
    }
    
    public function test_registration_failed(){
        // Call api endpoint
        $response = $this->postJson("/tenancy/register", [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'password'
        ]);

        // Assert the response
        $response->assertStatus(422);
        $response->assertJson([
            "success" => false,
            "message" => "Tenancy Account Cant't be Created."
        ]);
    }
}