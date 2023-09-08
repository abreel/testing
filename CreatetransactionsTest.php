<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Contract\Contract;
use Tests\TestCase;
class ContractControllerCreatetransactionsTest extends TestCase{
    use RefreshDatabase;

    public function test_create_transactions_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a contract
        $contract = Contract::factory()->create();

        // Call api endpoint
        $response = $this->postJson("/create-transactions", [
            'amount'     => 100,
            'contract_id' => $contract->id
        ]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertExactJson(['success' => true, 'message' => 'Contract Splitted Successfully']);
    }

    public function test_create_transactions_validation_failure()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/create-transactions", [
            'amount'     => 'abc',
            'contract_id' => '123'
        ]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertExactJson(
            [
                'success' => false,
                'message' => 'The amount must be a number.'
            ]
        );
    }

    public function test_create_transactions_contract_not_found()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/create-transactions", [
            'amount'     => 100,
            'contract_id' => 123
        ]);

        // Assert the response
        $response->assertStatus(404);
        $response->assertExactJson(
            [
                'success' => false,
                'message' => 'Contract not found'
            ]
        );
    }

    public function test_create_transactions_amount_credit_to_wallet_cannot_be_splitted()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a contract
        $contract = Contract::factory()->create();

        // Call api endpoint
        $response = $this->postJson("/create-transactions", [
            'amount'     => 100,
            'contract_id' => $contract->id
        ]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertExactJson(
            [
                'success' => false,
                'message' => 'Amount credited to wallet cannot be splitted to subaccounts. Kindly revise the subaccount settings and try again.'
            ]
        );
    }
}