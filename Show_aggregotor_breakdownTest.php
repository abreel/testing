<?php
use App\Models\User;
use App\Models\Aggregator;
use App\Models\WalletTransaction;
use Tests\TestCase;
class AggregatorControllerShow_aggregotor_breakdownTest extends TestCase
{
    public function test_show_aggregator_breakdown_success()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // create a valid aggregator
        $aggregator = Aggregator::factory()->create();

        // create credit and debit transactions
        $credit = WalletTransaction::factory()->create([
            'type' => 'CREDIT',
            'wallet_id' => $aggregator->wallet_id
        ]);
        $debit = WalletTransaction::factory()->create([
            'type' => 'DEBIT',
            'wallet_id' => $aggregator->wallet_id
        ]);

        $response = $this->getJson("/breakdown/{$aggregator->id}");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data' => [
                'breakdown' => [
                    'total_credit',
                    'total_debit'
                ],
                'balance'
            ]
        ]);
    }

    public function test_show_aggregator_breakdown_with_bad_id(){
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->getJson("/breakdown/0");
        $response->assertStatus(404);
        $response->assertJsonStructure([
            'success',
            'message'
        ]);
    }

    public function test_show_aggregator_breakdown_with_invalid_parameters(){
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->getJson("/breakdown/invalid");
        $response->assertStatus(400);
        $response->assertJsonStructure([
            'success',
            'message'
        ]);
    }
}