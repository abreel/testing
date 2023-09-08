<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Transaction;
use Tests\TestCase;

class PaymentControllerVerifypaymentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_authenticated_user_verify_payment_with_valid_transaction_id()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a transaction
        $transaction = Transaction::factory()->create([
            'customer_id' => $user->id
        ]);

        // Call api endpoint
        $response = $this->postJson("/payment/verify", [
            'transaction_id' => $transaction->id
        ]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'data',
            'newdata'
        ]);
        $this->assertEquals($response->getData()->status, true);
        $this->assertEquals($response->getData()->message, 'Transaction Successful');
        $this->assertIsArray($response->getData()->data);
        $this->assertIsArray($response->getData()->newdata);
    }

    /** @test */
    public function test_authenticated_user_verify_payment_with_invalid_transaction_id()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/payment/verify", [
            'transaction_id' => 'fake_id'
        ]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJsonStructure([
            'status',
            'message'
        ]);
        $this->assertEquals($response->getData()->status, false);
        $this->assertEquals($response->getData()->message, 'Invalid Transaction');
    }

    /** @test */
    public function test_authenticated_user_verify_payment_with_insufficient_fund()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a transaction
        $transaction = Transaction::factory()->create([
            'customer_id' => $user->id
        ]);

        // Call api endpoint
        $response = $this->postJson("/payment/verify", [
            'transaction_id' => $transaction->id
        ]);

        // Assert the response
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
        $this->assertEquals($response->getData()->status, false);
        $this->assertEquals($response->getData()->message, 'Insufficient Fund');
        $this->assertIsArray($response->getData()->data);
    }

    /** @test */
    public function test_authenticated_user_verify_payment_with_already_paid_transaction()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a transaction
        $transaction = Transaction::factory()->create([
            'customer_id' => $user->id,
            'status' => 'APPROVED'
        ]);

        // Call api endpoint
        $response = $this->postJson("/payment/verify", [
            'transaction_id' => $transaction->id
        ]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
        $this->assertEquals($response->getData()->status, true);
        $this->assertEquals($response->getData()->message, 'Payment made already');
        $this->assertIsArray($response->getData()->data);
    }

    /** @test */
    public function test_authenticated_user_verify_payment_with_cancelled_transaction()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a transaction
        $transaction = Transaction::factory()->create([
            'customer_id' => $user->id,
            'status' => 'CANCELLED'
        ]);

        // Call api endpoint
        $response = $this->postJson("/payment/verify", [
            'transaction_id' => $transaction->id
        ]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJsonStructure([
            'status',
            'message'
        ]);
        $this->assertEquals($response->getData()->status, false);
        $this->assertEquals($response->getData()->message, 'Transaction Failed');
    }

    /** @test */
    public function test_unauthenticated_user_verify_payment()
    {
        // Call api endpoint
        $response = $this->postJson("/payment/verify");

        // Assert the response
        $response->assertStatus(401);
        $response->assertJsonStructure([
            'message'
        ]);
        $this->assertEquals($response->getData()->message, 'Unauthenticated.');
    }
}
