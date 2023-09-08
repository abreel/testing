<?php
use App\Models\User;
use App\Models\Agent;
    use Tests\TestCase;
    class AgentControllerUpdateagentTest extends TestCase
    {
        public function test_update_agent_success()
        {
            // Create a user and authenticate
            $user = User::factory()->create();
            $this->actingAs($user);

            // Create an Agent
            $agent = Agent::factory()->create([
                'user_id' => $user->id
            ]);
            
            // Call api endpoint
            $response = $this->postJson("/agent/{$agent->id}", [
                'name' => 'John Doe',
                'status' => 'active',
                'users' => [$user->id],
                'accounts' => [$agent->accounts->id]
            ]);
            
            // Assert the response
            $response->assertStatus(200);
            $response->assertJson([
                'success' => true,
                'message' => 'Agent has been updated successfully'
            ]);
        }

        public function test_update_agent_failure_bad_validation()
        {
            // Create a user and authenticate
            $user = User::factory()->create();
            $this->actingAs($user);

            // Create an Agent
            $agent = Agent::factory()->create([
                'user_id' => $user->id
            ]);
            
            // Call api endpoint
            $response = $this->postJson("/agent/{$agent->id}", [
                'name' => 'John Doe',
                'status' => 'active',
                'users' => [], // no users
                'accounts' => [$agent->accounts->id]
            ]);
            
            // Assert the response
            $response->assertStatus(400);
            $response->assertJson([
                'success' => false,
                'message' => 'The users field is required.'
            ]);
        }

        public function test_update_agent_not_found()
        {
            // Create a user and authenticate
            $user = User::factory()->create();
            $this->actingAs($user);

            // Call api endpoint
            $response = $this->postJson("/agent/999", [
                'name' => 'John Doe',
                'status' => 'active',
                'users' => [$user->id],
                'accounts' => [999]
            ]);
            
            // Assert the response
            $response->assertStatus(404);
            $response->assertJson([
                'success' => false,
                'message' => 'Agent not found'
            ]);
        }
    }