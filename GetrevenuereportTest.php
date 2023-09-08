<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;

class ReportControllerGetrevenuereportTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_revenue_report_authentication_required()
    {
        // Call api endpoint
        $response = $this->getJson("/reports/revenue");

        // Assert the response
        $response->assertUnauthorized();
    }

    public function test_get_revenue_report_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/reports/revenue");

        // Assert the response
        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'revname',
                        'merchant_id',
                        'business_name',
                        'settlement_bank_id',
                        'settlement_bank_name',
                        'account_name',
                        'account_no',
                        'total_transaction_count',
                        'settlement_count',
                        'transfer_count',
                        'card_count',
                        'transfer_total',
                        'card_total',
                        'collection',
                        'settlement',
                        'balance',
                    ],
                ],
                'links',
                'meta',
            ]);
    }

    public function test_get_revenue_report_with_revenue_head_id()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/reports/revenue?revenue_head_id=1");

        // Assert the response
        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'revname',
                        'merchant_id',
                        'business_name',
                        'settlement_bank_id',
                        'settlement_bank_name',
                        'account_name',
                        'account_no',
                        'total_transaction_count',
                        'settlement_count',
                        'transfer_count',
                        'card_count',
                        'transfer_total',
                        'card_total',
                        'collection',
                        'settlement',
                        'balance',
                    ],
                ],
                'links',
                'meta',
            ]);
    }

    public function test_get_revenue_report_with_search()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/reports/revenue?search=some-search-string");

        // Assert the response
        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'revname',
                        'merchant_id',
                        'business_name',
                        'settlement_bank_id',
                        'settlement_bank_name',
                        'account_name',
                        'account_no',
                        'total_transaction_count',
                        'settlement_count',
                        'transfer_count',
                        'card_count',
                        'transfer_total',
                        'card_total',
                        'collection',
                        'settlement',
                        'balance',
                    ],
                ],
                'links',
                'meta',
            ]);
    }

    public function test_get_revenue_report_with_date_from()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/reports/revenue?date_from=2020-05-01");

        // Assert the response
        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'revname',
                        'merchant_id',
                        'business_name',
                        'settlement_bank_id',
                        'settlement_bank_name',
                        'account_name',
                        'account_no',
                        'total_transaction_count',
                        'settlement_count',
                        'transfer_count',
                        'card_count',
                        'transfer_total',
                        'card_total',
                        'collection',
                        'settlement',
                        'balance',
                    ],
                ],
                'links',
                'meta',
            ]);
    }

    public function test_get_revenue_report_with_date_to()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/reports/revenue?date_to=2020-05-01");

        // Assert the response
        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'revname',
                        'merchant_id',
                        'business_name',
                        'settlement_bank_id',
                        'settlement_bank_name',
                        'account_name',
                        'account_no',
                        'total_transaction_count',
                        'settlement_count',
                        'transfer_count',
                        'card_count',
                        'transfer_total',
                        'card_total',
                        'collection',
                        'settlement',
                        'balance',
                    ],
                ],
                'links',
                'meta',
            ]);
    }
}
