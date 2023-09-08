<?php
use App\Models\User;
use App\Models\Transaction;
use App\Models\Merchant;
use Tests\TestCase;
class PaymentControllerCanceltransferTest extends TestCase
{
    public function test_cancel_transfer_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a transaction
        $transaction = Transaction::factory()->create([
            'merchant_id' => $user->id
        ]);

        // Call api endpoint
        $response = $this->postJson("/api/v1/payment/transactions/cancel-transaction", [
            'transaction_id' => $transaction->id
        ]);

        // Assert the response
        $response->assertStatus(200)
            ->assertJson([
                'status' => true
            ]);
    }

    public function test_cancel_transfer_failure_invalid_merchant()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a transaction
        $transaction = Transaction::factory()->create();

        // Call api endpoint
        $response = $this->postJson("/api/v1/payment/transactions/cancel-transaction", [
            'transaction_id' => $transaction->id
        ]);

        // Assert the response
        $response->assertStatus(404)
            ->assertJson([
                'status' => false,
                'message' => 'Incorrect Key: Merchant Not Found'
            ]);
    }

    public function test_cancel_transfer_failure_invalid_transaction()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a merchant
        $merchant = Merchant::factory()->create();

        // Call api endpoint
        $response = $this->postJson("/api/v1/payment/transactions/cancel-transaction", [
            'transaction_id' => 1234
        ]);

        // Assert the response
        $response->assertStatus(404)
            ->assertJson([
                'status' => false,
                'message' => 'Invalid Transaction: Transaction Not Found'
            ]);
    }

    public function test_cancel_transfer_failure_invalid_data()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/api/v1/payment/transactions/cancel-transaction", [
            'transaction_id' => ''
        ]);

        // Assert the response
        $response->assertStatus(400)
            ->assertJson([
                'status' => false,
                'message' => 'The transaction id field is required.'
            ]);
    }
}