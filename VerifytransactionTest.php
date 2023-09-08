<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Merchant;
use App\Models\Transaction;
use App\Models\Customer;
use App\Models\VirtualAccount;
use App\Models\Account;
use App\Models\CommercialSetting;
use Tests\TestCase;
class VerifyTransactionTest extends TestCase{
    use RefreshDatabase;

    public function test_success_transaction_verification()
    {
        //Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a merchant
        $merchant = Merchant::factory()->create([
            'private_key' => 'test_key'
        ]);
        //Create a transaction
        $transaction = Transaction::factory()->create([
            'merchant_id' => $merchant->id,
            'status' => 'PENDING'
        ]);
        // Create a customer
        $customer = Customer::factory()->create();
        // Create a virtual account
        $virtualAccount = VirtualAccount::factory()->create([
            'wallet_id' => $customer->wallet_id
        ]);
        // Create an account
        $account = Account::factory()->create([
            'merchant_id' => $merchant->id,
            'aggregator_id' => 1
        ]);
        // Create a commercial setting
        $commercialSetting = CommercialSetting::factory()->create([
            'commercial_id' => $merchant->commercial_id,
            'name' => 'PROVIDER',
            'module' => 'WALLET',
            'type' => 'TRANSFER',
            'charge_type' => 'COLLECTION'
        ]);

        // Call api endpoint
        $response = $this->postJson("/api/v1/payment/transactions/verify-transaction", [
            'transaction_id' => $transaction->id,
            'private_key' => 'test_key'
        ]);

        // Assert the response
        $response->assertOk();
        $response->assertJson([
            'status' => true,
            'data' => [
                'transaction' => [
                    'orderid' => $transaction->order_id,
                    'transid' => $transaction->id,
                    'date_paid' => $transaction->date_paid,
                    'status' => $transaction->status,
                    'channel' => $transaction->channel
                ]
            ]
        ]);
    }

    public function test_failed_transaction_verification()
    {
        //Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a merchant
        $merchant = Merchant::factory()->create([
            'private_key' => 'test_key'
        ]);
        //Create a transaction
        $transaction = Transaction::factory()->create([
            'merchant_id' => $merchant->id,
            'status' => 'PENDING'
        ]);
        // Create a customer
        $customer = Customer::factory()->create();
        // Create a virtual account
        $virtualAccount = VirtualAccount::factory()->create([
            'wallet_id' => $customer->wallet_id
        ]);
        // Create an account
        $account = Account::factory()->create([
            'merchant_id' => $merchant->id,
            'aggregator_id' => 1
        ]);

        // Call api endpoint
        $response = $this->postJson("/api/v1/payment/transactions/verify-transaction", [
            'transaction_id' => $transaction->id,
            'private_key' => 'invalid_key'
        ]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            'status' => false,
            'message' => 'Invalid Transaction'
        ]);
    }

    public function test_failed_transaction_due_to_expiry()
    {
        //Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a merchant
        $merchant = Merchant::factory()->create([
            'private_key' => 'test_key'
        ]);
        //Create a transaction
        $transaction = Transaction::factory()->create([
            'merchant_id' => $merchant->id,
            'status' => 'PENDING',
            'created_at' => Carbon::now()->subDays(2)
        ]);
        // Create a customer
        $customer = Customer::factory()->create();
        // Create a virtual account
        $virtualAccount = VirtualAccount::factory()->create([
            'wallet_id' => $customer->wallet_id
        ]);
        // Create an account
        $account = Account::factory()->create([
            'merchant_id' => $merchant->id,
            'aggregator_id' => 1
        ]);

        // Call api endpoint
        $response = $this->postJson("/api/v1/payment/transactions/verify-transaction", [
            'transaction_id' => $transaction->id,
            'private_key' => 'test_key'
        ]);

        // Assert the response
        $response->assertStatus(422);
        $response->assertJson([
            'status' => false,
            'message' => 'Transaction Declined',
            'data' => [
                'orderid' => $transaction->order_id,
                'transid' => $transaction->id,
                'date_paid' => $transaction->date_paid,
                'status' => 'FAILED',
                'channel' => $transaction->channel
            ]
        ]);
    }

    public function test_failed_transaction_due_to_insufficient_balance()
    {
        //Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a merchant
        $merchant = Merchant::factory()->create([
            'private_key' => 'test_key'
        ]);
        //Create a transaction
        $transaction = Transaction::factory()->create([
           