<?php
use App\Models\User;
use App\Models\ProviderTransaction;
use Tests\TestCase;

class TransactionControllerRefunddetailsTest extends TestCase
{
    public function test_retrieve_refund_details_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a transaction record
        $transaction = ProviderTransaction::factory()->create();

        // Call api endpoint
        $response = $this->getJson("/payment/transactions/refund-details?sessionId={$transaction->transaction_reference}");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Refund Details generated successfully',
            'data' => $this->transform($transaction->toArray()),
        ]);
    }

    public function test_retrieve_refund_details_failure()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/payment/transactions/refund-details?sessionId=invalid-session-id");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'success' => false,
            'message' => 'Refund Details not found',
            'data' => [],
        ]);
    }

    public function test_retrieve_refund_details_validation_error()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/payment/transactions/refund-details");

        // Assert the response
        $response->assertStatus(422);
        $response->assertJson([
            'success' => false,
            'message' => 'Validation Error',
            'data' => [
                'sessionId' => [
                    'The session id field is required.'
                ]
            ]
        ]);
    }

    protected function transform($transaction)
    {
        return [
            'transaction_id' => $transaction['id'],
            'order_id' => $transaction['order_id'],
            'amount' => $transaction['amount'],
            'refund_amount' => $transaction['refund_amount'],
            'status' => $transaction['status'],
            'refund_status' => $transaction['refund_status'],
        ];
    }
}
