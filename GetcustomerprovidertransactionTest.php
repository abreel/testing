<?php
use App\Models\User;
use App\Models\VirtualAccount;
use App\Models\ProviderTransaction;
use Tests\TestCase;
class CustomerControllerGetcustomerprovidertransactionTest extends TestCase
{
    public function test_get_customer_provider_transaction_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create virtual account numbers
        $virtualAccountNumbers = VirtualAccount::factory()->count(3)->create();

        // Create provider transactions
        $providerTransactions = ProviderTransaction::factory()->count(3)->create();

        // Call api endpoint
        $response = $this->getJson("/payment/customers/provider-transactions", [
            'customer_id' => $virtualAccountNumbers[0]->wallet->customer->id
        ]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data' => [
                'current_page',
                'data' => [
                    [
                        'id',
                        'reference_number',
                        'craccount',
                        'amount',
                        'created_at',
                        'updated_at',
                    ]
                ],
            ],
        ]);
        $this->assertEquals(count($providerTransactions), count($response->json('data.data')));
    }

    public function test_get_customer_provider_transaction_with_pagination()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create virtual account numbers
        $virtualAccountNumbers = VirtualAccount::factory()->count(3)->create();

        // Create provider transactions
        $providerTransactions = ProviderTransaction::factory()->count(3)->create();

        // Call api endpoint
        $response = $this->getJson("/payment/customers/provider-transactions", [
            'customer_id' => $virtualAccountNumbers[0]->wallet->customer->id,
            'perPage' => 2
        ]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data' => [
                'current_page',
                'data' => [
                    [
                        'id',
                        'reference_number',
                        'craccount',
                        'amount',
                        'created_at',
                        'updated_at',
                    ]
                ],
            ],
        ]);
        $this->assertEquals(2, count($response->json('data.data')));
    }

    public function test_get_customer_provider_transaction_failure()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/payment/customers/provider-transactions", [
            'customer_id' => 1
        ]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data' => [
                'current_page',
                'data' => []
            ],
        ]);
        $this->assertEquals(0, count($response->json('data.data')));
    }

    public function test_get_customer_provider_transaction_bad_validation()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/payment/customers/provider-transactions");

        // Assert the response
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'customer_id'
            ]
        ]);
    }
}