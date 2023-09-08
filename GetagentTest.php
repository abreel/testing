<?php
use App\Models\User;
use App\Models\Agent;
use Tests\TestCase;

class AgentControllerGetagentTest extends TestCase
{
    /**
     * Test the getAgent method returns a success response with the valid data
     *
     * @return void
     */
    public function testGetAgentSuccess()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $agent = Agent::factory()->create();
        $response = $this->getJson("/agents/{$agent->id}");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['users', 'accounts']]);
    }

    /**
     * Test the getAgent method returns a bad request response when no agent is found
     *
     * @return void
     */
    public function testGetAgentFailure()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $invalidId = 9999;
        $response = $this->getJson("/agents/{$invalidId}");

        // Assert the response
        $response->assertStatus(400);
    }
}
