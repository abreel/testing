<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Merchant;
use App\Models\Account;
use App\Models\Aggregator;
use App\Models\Wallet;
use App\Models\VirtualAccount;
use App\Models\Bank;
use Tests\TestCase;

class WalletControllerWithdrawpublicTest extends TestCase
{
    use RefreshDatabase;

    public function test_withdraw_public_success()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $privateKey = $this->faker->uuid;
        $merchant = Merchant::factory()->create([
            'private_key' => $privateKey
        ]);
        $account = Account::factory()->create([
            'id' => $merchant->account_id
        ]);
        $aggregator = Aggregator::factory()->create([
            'account_id' => $account->id
        ]);

        $aggregatorAccount = Account::factory()->create([
            'id' => $aggregator->account_id
        ]);
        $wallet = Wallet::factory()->create([
            'id' => $aggregatorAccount->wallet_id
        ]);
        $virtualAccount = VirtualAccount::factory()->create([
            'wallet_id' => $wallet->id
        ]);

        $bank = Bank::factory()->create();
        $balance = $this->faker->numberBetween(1, 500);
        $requestData = [
            'amount' => $balance,
            'bank_code' => $bank->code,
            'account_number' => $this->faker->bankAccountNumber
        ];
        $response = $this->postJson('/api/v1/payment/withdraw', $requestData, [
            'Authorization' => "Bearer {$privateKey}"
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'success',
            'data' => [
                'id',
                'wallet_id',
                'aggregator_id',
                'amount',
                'status',
                'purpose',
                'description',
                'transaction_type',
                'merchant_id',
                'created_at',
                'updated_at'
            ]
        ]);
    }

    public function test_withdraw_public_failure_bad_validation()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $privateKey = $this->faker->uuid;
        $merchant = Merchant::factory()->create([
            'private_key' => $privateKey
        ]);
        $account = Account::factory()->create([
            'id' => $merchant->account_id
        ]);
        $aggregator = Aggregator::factory()->create([
            'account_id' => $account->id
        ]);

        $aggregatorAccount = Account::factory()->create([
            'id' => $aggregator->account_id
        ]);
        $wallet = Wallet::factory()->create([
            'id' => $aggregatorAccount->wallet_id
        ]);
        $virtualAccount = VirtualAccount::factory()->create([
            'wallet_id' => $wallet->id
        ]);

        $bank = Bank::factory()->create();
        $balance = $this->faker->numberBetween(1, 499);
        $requestData = [
            'amount' => $balance,
            'bank_code' => $bank->code,
            'account_number' => $this->faker->bankAccountNumber
        ];
        $response = $this->postJson('/api/v1/payment/withdraw', $requestData, [
            'Authorization' => "Bearer {$privateKey}"
        ]);

        $response->assertStatus(400);
        $response->assertJsonStructure([
            'success',
            'message'
        ]);
    }

    public function test_withdraw_public_failure_insufficient_fund()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $privateKey = $this->faker->uuid;
        $merchant = Merchant::factory()->create([
            'private_key' => $privateKey
        ]);
        $account = Account::factory()->create([
            'id' => $merchant->account_id
        ]);
        $aggregator = Aggregator::factory()->create([
            'account_id' => $account->id
        ]);

        $aggregatorAccount = Account::factory()->create([
            'id' => $aggregator->account_id
        ]);
        $wallet = Wallet::factory()->create([
            'id' => $aggregatorAccount->wallet_id
        ]);
        $virtualAccount = VirtualAccount::factory()->create([
            'wallet_id' => $wallet->id
        ]);

        $bank = Bank::factory()->create();
        $balance = $this->faker->numberBetween(501, 1000);
        $requestData = [
            'amount' => $balance,
            'bank_code' => $bank->code,
            'account_number' => $this->faker->bankAccountNumber
        ];
        $response = $this->postJson('/api/v1/payment/withdraw', $requestData, [
            'Authorization' => "Bearer {$privateKey}"
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'success',
            'message'
        ]);
    }
}
