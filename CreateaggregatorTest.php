<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;

class AggregatorControllerCreateaggregatorTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_aggregator_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/", [
            'name' => 'Aggregator 1',
            'user_id' => $user->id,
            'account_id' => '12345'
        ]);

        // Assert the response
        $response->assertStatus(201);
        $response->assertJson([
            'success' => true,
            'message' => 'Aggregator Created Successfully'
        ]);
    }

    public function test_create_aggregator_bad_validation()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/", [
            'name' => '',
            'user_id' => $user->id,
            'account_id' => '12345'
        ]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'The name field is required.'
        ]);
    }

    public function test_create_aggregator_failure()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/", [
            'name' => 'Aggregator 1',
            'user_id' => $user->id,
            'account_id' => ''
        ]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'Aggregator not created'
        ]);
    }
}