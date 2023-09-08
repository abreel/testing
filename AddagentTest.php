<?php
use App\Models\User;
use Tests\TestCase;
class AgentControllerAddagentTest extends TestCase
{
    public function test_create_agent_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'name' => 'John Doe',
            'accounts' => [1, 2],
            'status' => 'active',
            'users' => [1],
        ];
        $response = $this->postJson('/core/agents/', $data);

        $response->assertStatus(200);
        $response->assertJsonStructure(['success','data','message']);
        $this->assertDatabaseHas('agents', [
            'name' => 'John Doe',
            'status' => 'active',
        ]);
    }

    public function test_create_agent_failure_bad_validation()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'name' => '',
            'accounts' => [1, 2],
            'status' => 'active',
            'users' => [1],
        ];
        $response = $this->postJson('/core/agents/', $data);

        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'The name field is required.',
        ]);
    }

    public function test_create_agent_failure_unauthorized()
    {
        $data = [
            'name' => 'John Doe',
            'accounts' => [1, 2],
            'status' => 'active',
            'users' => [1],
        ];
        $response = $this->postJson('/core/agents/', $data);

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Unauthenticated.',
        ]);
    }
}