<?php
use App\Models\User;
use App\Models\Contract\Contract;
use App\Models\Contract\ContractSubaccount;
use Tests\TestCase;
class ContractControllerUpdatesubaccountTest extends TestCase
{
    public function test_subaccount_not_found()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint with unexisting subaccount
        $response = $this->getJson("/update-subaccount/9999");
        
        // Assert the response
        $response->assertStatus(404);
        $response->assertJson(['success' => false, 'message' => 'Subaccount not found']);
    }

    public function test_total_percentage_greater_than_100()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a contract
        $contract = Contract::factory()->create();

        // Create two subaccounts
        $subaccount1 = ContractSubaccount::factory()->create([
            'contract_id' => $contract->id,
            'percent_amount' => 50,
        ]);
        $subaccount2 = ContractSubaccount::factory()->create([
            'contract_id' => $contract->id,
            'percent_amount' => 50,
        ]);

        // Call api endpoint with total sum of percent_amount greater than 100
        $response = $this->postJson("/update-subaccount/{$subaccount1->id}", [
            'contract_id' => $contract->id,
            'percent_amount' => 51,
        ]);

        // Assert the response
        $response->assertStatus(422);
        $response->assertJson([
            'success' => false,
            'message' => "Total percentage assigned is greater than 100. 
                            Kindly revise and try again",
        ]);
    }

    public function test_subaccount_updated_successfuly()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a contract
        $contract = Contract::factory()->create();

        // Create a subaccount
        $subaccount = ContractSubaccount::factory()->create([
            'contract_id' => $contract->id,
            'percent_amount' => 50,
            'fixed_amount' => 1000,
            'access_type' => 'view',
        ]);

        // Call api endpoint with valid data
        $response = $this->postJson("/update-subaccount/{$subaccount->id}", [
            'contract_id' => $contract->id,
            'percent_amount' => 65,
            'fixed_amount' => 2000,
            'access_type' => 'edit',
        ]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['success' => true, 'message' => 'Subaccount Updated sucessfully']);
    }
}