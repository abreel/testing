<?php
use App\Models\User;
use App\Models\Aggregator;
use Tests\TestCase;
class AggregatorControllerUpdateaggregatorTest extends TestCase
{
    public function testSuccessfulUpdate()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Create a new aggregator
        $aggregatorId = Aggregator::factory()->create([
            'user_id' => $user->id
        ]);

        // Send request to the api endpoint
        $response = $this->postJson("/{$aggregatorId->id}", [
            'name' => 'TestAggregator',
            'user_id' => $user->id,
            'account_id' => 'test-account'
        ]);
        
        // Assert response
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Aggregator Updated Successfully'
        ]);
        $this->assertDatabaseHas('aggregators', [
            'id' => $aggregatorId->id,
            'name' => 'TestAggregator',
            'user_id' => $user->id,
            'account_id' => 'test-account'
        ]);
    }

    public function testAggregatorNotFound()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Send request to the api endpoint
        $response = $this->postJson("/1", [
            'name' => 'TestAggregator',
            'user_id' => $user->id,
            'account_id' => 'test-account'
        ]);
        
        // Assert response
        $response->assertStatus(404);
        $response->assertJson([
            'success' => false,
            'message' => 'Aggregator Not Found'
        ]);
    }

    public function testValidationFails()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a new aggregator
        $aggregatorId = Aggregator::factory()->create([
            'user_id' => $user->id
        ]);

        // Send request to the api endpoint
        $response = $this->postJson("/{$aggregatorId->id}", [
            'name' => '',
            'user_id' => '',
            'account_id' => ''
        ]);
        
        // Assert response
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'The name field is required.'
        ]);
    }
}