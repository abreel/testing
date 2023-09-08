<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;

class WalletControllerTransferTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function transfer_validation_fails_for_invalid_input()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson('/api/v1/banking/wallet/transfer', [
            'amount' => '',
            'bank_code' => 'test',
            'account_number' => '',
            'wallet_id' => '',
            'type' => '',
            'schedule_time' => '',
        ]);

        $response->assertStatus(400);
        $response->assertExactJson([
            'success' => false,
            'message' => 'The amount field is required.',
        ]);
    }

    /** @test */
    public function transfer_validation_fails_for_invalid_amount()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson('/api/v1/banking/wallet/transfer', [
            'amount' => '-10',
            'bank_code' => '001',
            'account_number' => '123456789',
            'wallet_id' => '1',
            'type' => 'schedule',
            'schedule_time' => '2019-12-12',
        ]);

        $response->assertStatus(400);
        $response->assertExactJson([
            'success' => false,
            'message' => 'Invalid amount passed',
            'data' => [
                'amount' => '-10',
                'bank_code' => '001',
                'account_number' => '123456789',
                'wallet_id' => '1',
                'type' => 'schedule',
                'schedule_time' => '2019-12-12',
            ],
        ]);
    }

    /** @test */
    public function transfer_validation_fails_for_schedule_transfer_without_schedule_time()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson('/api/v1/banking/wallet/transfer', [
            'amount' => '10',
            'bank_code' => '001',
            'account_number' => '123456789',
            'wallet_id' => '1',
            'type' => 'schedule',
        ]);

        $response->assertStatus(400);
        $response->assertExactJson([
            'success' => false,
            'message' => 'schedule_time is required for schedule',
        ]);
    }

    /** @test */
    public function transfer_success_for_internal_transfer()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson('/api/v1/banking/wallet/transfer', [
            'amount' => '10',
            'bank_code' => '001',
            'account_number' => '123456789',
            'wallet_id' => '1',
            'type' => 'schedule',
            'schedule_time' => '2019-12-12',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'transaction_id',
                'amount',
                'bank_code',
                'account_number',
                'type',
                'narration',
                'schedule_time',
            ],
        ]);
    }
}