<?php
use App\Models\User;
use Tests\TestCase;
class ProviderControllerGetbalanceTest extends TestCase
{
    public function testGetBalanceSuccess()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->getJson("/provider/disbursement/get/balance");
        
        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure($this->getExpectedStructure());
    }
    
    public function testGetBalanceServiceUnavailable()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Mock a service exception
        $mock = Mockery::mock('overload:Service');
        $mock->shouldReceive('getBalance')->andThrow(new \Exception());
        
        // Call api endpoint
        $response = $this->getJson("/provider/disbursement/get/balance");
        
        // Assert the response
        $response->assertStatus(500);
        $response->assertJsonStructure(['message', 'errors']);
    }
    
    public function testGetBalanceUnauthorized()
    {
        // Call api endpoint
        $response = $this->getJson("/provider/disbursement/get/balance");
        
        // Assert the response
        $response->assertStatus(401);
        $response->assertJsonStructure(['message', 'errors']);
    }
    
    protected function getExpectedStructure()
    {
        return [
            'message',
            'data' => [
                'balance'
            ]
        ];
    }
}