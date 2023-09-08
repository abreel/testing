<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Agent;
use App\Models\Account;
use Tests\TestCase;

class AgentControllerAssignaccountTest extends TestCase
{
    use RefreshDatabase;

    public function test_assign_accounts_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create agent
        $agent = Agent::factory()->create();

        // Create accounts
        $accounts = Account::factory()->count(3)->create();

        // Create users
        $users = User::factory()->count(3)->create();

        // Call api endpoint
        $response = $this->postJson("/core/agents/assign-account", [
            'agent_id' => $agent->id,
            'accounts' => $accounts->pluck('id')->toArray(),
            'users' => $users->pluck('id')->toArray(),
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'success' => true,
                'message' => 'Accounts Assigned To Agent Successfully'
            ]);
    }

    public function test_assign_accounts_validation_fail()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint without required params
        $response = $this->postJson("/core/agents/assign-account");

        $response->assertStatus(400)
            ->assertJsonFragment([
                'success' => false,
            ]);
    }

    public function test_assign_accounts_failure()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint with invalid params
        $response = $this->postJson("/core/agents/assign-account", [
            'agent_id' => 'invalid',
            'accounts' => [1,2,3],
            'users' => [4,5,6],
        ]);

        $response->assertStatus(400)
            ->assertJsonFragment([
                'success' => false,
            ]);
    }
}