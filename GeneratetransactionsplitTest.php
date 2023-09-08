<?php
use App\Models\Transaction;
use App\Http\Controllers\Payment\PaymentController;
use Tests\TestCase;

class TransactionControllerGeneratetransactionsplitTest extends TestCase
{
    public function test_success_status_code()
    {
        // Create a transaction
        $transaction = Transaction::factory()->create();

        // Call api endpoint
        $response = $this->postJson("/transaction/split/{$transaction->id}");

        // Assert the response
        $response->assertStatus(200);
    }

    public function test_failure_status_code()
    {
        // Call api endpoint
        $response = $this->postJson("/transaction/split/0");

        // Assert the response
        $response->assertStatus(404);
    }

    public function test_success_response_format()
    {
        // Create a transaction
        $transaction = Transaction::factory()->create();

        // Call api endpoint
        $response = $this->postJson("/transaction/split/{$transaction->id}");

        // Assert the response
        $response->assertJson([
            'status' => true,
            'message' => 'Transaction splitted successfully',
        ]);
    }

    public function test_failure_response_format()
    {
        // Create a transaction and split it
        $transaction = Transaction::factory()->create();
        $payment = new PaymentController();
        $payment->generateTransactionSplitLogic($transaction);

        // Call api endpoint
        $response = $this->postJson("/transaction/split/{$transaction->id}");

        // Assert the response
        $response->assertJson([
            'status' => true,
            'message' => 'Transaction has been splitted',
        ]);
    }
}
