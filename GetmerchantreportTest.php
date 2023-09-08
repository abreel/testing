<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Merchant;
use Tests\TestCase;
class ReportControllerGetmerchantreportTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test for successful merchant report retrieval
     *
     * @return void
     */
    public function test_successful_merchant_report_retrieval()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a merchant
        $merchant = Merchant::factory()->create();

        // Call api endpoint
        $response = $this->getJson("/reports/merchant?merchant_id={$merchant->id}");

        // Assert that the response is successful
        $response->assertStatus(200);

        // Assert that the response structure matches the expected structure
        $response->assertJsonStructure([
            'data' => [
                'merchant_id',
                'business_name',
                'business_phone',
                'business_email',
                'total_transaction_count',
                'settlement_count',
                'transfer_count',
                'card_count',
                'transfer_total',
                'card_total',
                'collection',
                'settlement',
                'balance'
            ],
            'links' => [
                'first',
                'last',
                'prev',
                'next'
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'path',
                'per_page',
                'to',
                'total'
            ]
        ]);
    }

    /**
     * Test for unsuccessful merchant report retrieval when merchant id is not provided
     *
     * @return void
     */
    public function test_unsuccessful_merchant_report_retrieval_when_merchant_id_is_not_provided()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/reports/merchant");

        // Assert that the response is not successful
        $response->assertStatus(400);

        // Assert that the response error message matches the expected message
        $response->assertJson([
            'message' => 'The merchant id field is required.'
        ]);
    }

    /**
     * Test for unsuccessful merchant report retrieval when merchant does not exist
     *
     * @return void
     */
    public function test_unsuccessful_merchant_report_retrieval_when_merchant_does_not_exist()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/reports/merchant?merchant_id=123456");

        // Assert that the response is not successful
        $response->assertStatus(404);

        // Assert that the response error message matches the expected message
        $response->assertJson([
            'message' => 'The merchant with id 123456 does not exist.'
        ]);
    }
}