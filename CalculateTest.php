<?php
use App\Models\User;
use Tests\TestCase;
class CommercialControllerCalculateTest extends TestCase
{
     public function testCalculateSuccess()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/commercials/logic", [
            'commercial_id' => $user->id,
            'transaction_type' => 'transfer',
            'amount' => '1000'
        ]);
 
        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'total_amount',
            'charges'
        ]);
    }

    public function testCalculateBadValidation()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/commercials/logic", [
            'commercial_id' => $user->id,
            'transaction_type' => 'transfers',
            'amount' => '1000'
        ]);
 
        // Assert the response
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['transaction_type']);
    }

    public function testCalculateFailed()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/commercials/logic", [
            'commercial_id' => $user->id,
            'transaction_type' => 'transfer',
            'amount' => 'abc'
        ]);
 
        // Assert the response
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['amount']);
    }

}