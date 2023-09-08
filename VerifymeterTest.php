<?php
use App\Models\User;
use Tests\TestCase;
class BillsControllerVerifymeterTest extends TestCase
{
    public function test_successful_meter_verification()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Create payload
        $payload = [
            'api_key' => env('BILLS_PROVIDER_KEY'),
            'product_code' => '1234',
            'meter_number' => '5678',
            'task' => 'verify'
        ];
        
        // Call api endpoint
        $response = $this->postJson("/bills/electric/verify-meter", $payload);
        
        // Assert the response
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Meter Verification Successful',
                'data' => $response->original['data'],
            ]);
    }
    
    public function test_failed_meter_verification()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Create payload
        $payload = [
            'api_key' => env('BILLS_PROVIDER_KEY'),
            'product_code' => '',
            'meter_number' => '',
            'task' => 'verify'
        ];
        
        // Call api endpoint
        $response = $this->postJson("/bills/electric/verify-meter", $payload);
        
        // Assert the response
        $response
            ->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'The product code field is required.'
            ]);
    }
    
    public function test_bad_validation_meter_verification()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Create payload
        $payload = [
            'api_key' => env('BILLS_PROVIDER_KEY'),
            'product_code' => 'abcd',
            'meter_number' => '1234',
            'task' => 'verify'
        ];
        
        // Call api endpoint
        $response = $this->postJson("/bills/electric/verify-meter", $payload);
        
        // Assert the response
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => false,
                'message' => 'Error Verifying Meter'
            ]);
    }
}