<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Transaction;
use Tests\TestCase;
class PaymentControllerInitcardTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test successful request.
     *
     * @return void
     */
    public function testSuccessfulRequest()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create transaction
        $transaction = Transaction::factory()->create(['user_id' => $user->id]);

        // Call api endpoint
        $response = $this->postJson("/payment/transactions/init-card", ['transaction_id' => $transaction->id]);
            
        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure(['status', 'message', 'data']);
        $response->assertJson(['status' => true]);
    }

    /**
     * Test request with invalid transaction.
     *
     * @return void
     */
    public function testRequestWithInvalidTransaction()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/payment/transactions/init-card", ['transaction_id' => 'invalid_id']);
            
        // Assert the response
        $response->assertStatus(404);
        $response->assertJsonStructure(['status', 'message']);
        $response->assertJson(['status' => false]);
    }

    /**
     * Test request without transaction.
     *
     * @return void
     */
    public function testRequestWithoutTransaction()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/payment/transactions/init-card");
            
        // Assert the response
        $response->assertStatus(400);
        $response->assertJsonStructure(['status', 'message']);
        $response->assertJson(['status' => false]);
    }
}