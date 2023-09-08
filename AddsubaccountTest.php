<?php
use App\Models\User;
use App\Models\Contract\Contract;
use Tests\TestCase;

class ContractControllerAddsubaccountTest extends TestCase
{
    public function test_add_subaccount_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a contract
        $contract = Contract::factory()->create();

        // Call api endpoint
        $response = $this->postJson("/add-subaccount/{$contract->id}", [
            'users' => [
                [
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'email' => 'johndoe@example.com',
                    'percent_amount' => 10,
                    'fixed_amount' => 0,
                    'access_type' => 'read'
                ]
            ]
        ]);

        // Assert the response
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'User Added to Contract Successfully'
            ]);
    }

    public function test_add_subaccount_failure_missing_user_data()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a contract
        $contract = Contract::factory()->create();

        // Call api endpoint
        $response = $this->postJson("/add-subaccount/{$contract->id}", []);

        // Assert the response
        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'The users field is required.'
            ]);
    }

    public function test_add_subaccount_failure_invalid_percent_amount()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a contract
        $contract = Contract::factory()->create();

        // Call api endpoint
        $response = $this->postJson("/add-subaccount/{$contract->id}", [
            'users' => [
                [
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'email' => 'johndoe@example.com',
                    'percent_amount' => 110,
                    'fixed_amount' => 0,
                    'access_type' => 'read'
                ]
            ]
        ]);

        // Assert the response
        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Total percentage assigned is greater than 100. Kindly revise and try again'
            ]);
    }

    public function test_add_subaccount_failure_contract_not_found()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/add-subaccount/1000", [
            'users' => [
                [
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'email' => 'johndoe@example.com',
                    'percent_amount' => 110,
                    'fixed_amount' => 0,
                    'access_type' => 'read'
                ]
            ]
        ]);

        // Assert the response
        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'Contract not found'
            ]);
    }
}
