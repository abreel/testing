<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Settlement;
use App\Models\TransactionSplit;
use App\Models\Wallet;
use App\Models\VirtualAccount;
use Tests\TestCase;

class SettlementAdminControllerProcessbulksettlementTest extends TestCase
{
    use RefreshDatabase;

    public function test_successful_processing()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a batch
        $batch = SettlementBatch::factory()->create();

        // Create a settlement with pending status
        $settlement = Settlement::factory()->create(['status' => 'PENDING']);

        // Create a transaction split
        TransactionSplit::factory()->create([
            'settlement_batch' => $batch->id,
            'settlement_id' => $settlement->id,
            'split_amount' => 500
        ]);

        // Create a virtual account 
        $walletId = Wallet::factory()->create()->id;
        $virtualAccount = VirtualAccount::factory()->create(['wallet_id' => $walletId]);

        // Call api endpoint
        $response = $this->getJson("/process-bulk/{$batch->id}");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Settlement processed successfully'
        ]);

        // Assert the settlement status
        $this->assertEquals('PAID', Settlement::first()->status);
    }

    public function test_no_settlement_for_processing()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a batch
        $batch = SettlementBatch::factory()->create();

        // Call api endpoint
        $response = $this->getJson("/process-bulk/{$batch->id}");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'No Settlement for processing'
        ]);
    }

    public function test_validation_failed()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a batch
        $batch = SettlementBatch::factory()->create();

        // Create a settlement with pending status
        $settlement = Settlement::factory()->create(['status' => 'PENDING']);

        // Create a transaction split
        TransactionSplit::factory()->create([
            'settlement_batch' => $batch->id,
            'settlement_id' => $settlement->id,
            'split_amount' => 500
        ]);

        // Call api endpoint
        $response = $this->postJson("/process-bulk/{$batch->id}");

        // Assert the response
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['wallet_id', 'amount', 'description', 'craccount_no', 'craccount_name', 'craccount_bank']);
    }
}