<?php
use App\Models\User;
use Tests\TestCase;
class UssdControllerUssdrequesthandlerTest extends TestCase{

    public function test_handle_return_user_success()
    {
        // Create a phone number and authenticate
        $phoneNumber = '+254712345678';
        $user = User::factory()->create(['phone' => $phoneNumber]);
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson('/api/v1/ussd', [
            'sessionId' => 'random-session-id',
            'serviceCode' => '123*1',
            'phoneNumber' => $phoneNumber,
            'text' => '*123#'
        ]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Ussd request was handled successfully'
        ]);
    }

    public function test_handle_return_user_failure()
    {
        // Create a phone number and authenticate
        $phoneNumber = '+254712345678';
        $user = User::factory()->create(['phone' => $phoneNumber]);
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson('/api/v1/ussd', [
            'sessionId' => 'random-session-id',
            'serviceCode' => '123*1',
            'phoneNumber' => $phoneNumber,
            'text' => 'random-text'
        ]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            'message' => 'Invalid USSD request'
        ]);
    }

    public function test_handle_new_user_success()
    {
        // Create a phone number and authenticate
        $phoneNumber = '+254712345678';
        $user = User::factory()->create(['phone' => $phoneNumber]);
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson('/api/v1/ussd', [
            'sessionId' => 'random-session-id',
            'serviceCode' => '123*1',
            'phoneNumber' => $phoneNumber,
            'text' => '*123#'
        ]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Ussd request was handled successfully'
        ]);
    }

    public function test_handle_new_user_failure()
    {
        // Create a phone number and authenticate
        $phoneNumber = '+254712345678';
        $user = User::factory()->create(['phone' => $phoneNumber]);
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson('/api/v1/ussd', [
            'sessionId' => 'random-session-id',
            'serviceCode' => '123*1',
            'phoneNumber' => $phoneNumber,
            'text' => 'random-text'
        ]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            'message' => 'Invalid USSD request'
        ]);
    }

    public function test_ussd_stop()
    {
        // Create a phone number and authenticate
        $phoneNumber = '+254712345678';
        $user = User::factory()->create(['phone' => $phoneNumber]);
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson('/api/v1/ussd', [
            'sessionId' => 'random-session-id',
            'serviceCode' => '123*1',
            'phoneNumber' => 'random-phone-number',
            'text' => '*123#'
        ]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'This phone number is not registered'
        ]);
    }

}