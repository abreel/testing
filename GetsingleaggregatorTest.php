<?php
use App\Models\Aggregator;
use Tests\TestCase;

class AggregatorControllerGetsingleaggregatorTest extends TestCase
{
    public function test_get_aggregator_success()
    {
        // Create an aggregator
        $aggregator = Aggregator::factory()->create();
        $response = $this->getJson("/single-aggregator/{$aggregator->id}");
        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Aggregator Generated Succesfully',
            'data' => $aggregator
        ]);
    }
    public function test_get_aggregator_invalid_id()
    {
        // Call api endpoint
        $response = $this->getJson("/single-aggregator/999");
        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'Aggregator Not Found'
        ]);
    }
}
