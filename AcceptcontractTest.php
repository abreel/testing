<?php
use App\Models\User;
use App\Models\Contract\ContractSubaccount;
use App\Models\Contract\Contract;
use Tests\TestCase;
class ContractControllerAcceptcontractTest extends TestCase
{
    public function test_accept_contract_success()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $token = Str::random(10);

        $contract = ContractSubaccount::factory()->create([
            'email_code' => $token,
            'access_type' => 'personal',
            'user_id' => $user->id
        ]);

        $contracts = Contract::factory()->create([
            'id' => $contract->contract_id,
        ]);

        $response = $this->getJson("/accept/{$token}");
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $response->assertJson(['data' => $contracts]);
    }

    public function test_accept_contract_not_found()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $token = Str::random(10);
        
        $response = $this->getJson("/accept/{$token}");
        $response->assertStatus(404);
        $response->assertJson(['success' => false]);
        $response->assertJson(['message' => 'Contract not found']);
    }
}