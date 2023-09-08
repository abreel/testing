<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;
class DashboardAnalyticsControllerFetch_dashboard_analyticsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test Successful Fetch Dashboard Analytics
     *
     * @return void
     */
    public function test_successful_fetch_dashboard_analytics()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson('/core/general/dashboard_stats', [
            'active_account' => $user->active_account,
            'active_merchant' => $user->active_merchant,
        ]);

        // Assert the response
        $response->assertStatus(200)
            ->assertJsonStructure([
            'success',
            'data' => [
                'total_revenue',
                'total_wallet',
                'total_customer',
                'total_transaction',
                'total_payment_today',
                'total_payment_last_7days',
                'total_payment_last_1months',
                'recent_transations' => [
                    [
                        'id',
                        'merchant_id',
                        'customer_id',
                        'amount',
                        'channel',
                        'status',
                        'date_paid',
                        'created_at',
                        'customer' => [
                            'id',
                            'first_name',
                            'last_name',
                        ],
                        'merchant' => [
                            'id',
                            'business_name',
                        ],
                    ],
                ],
            ],
        ]);
    }

    /**
     * Test Failed Fetch Dashboard Analytics
     *
     * @return void
     */
    public function test_failed_fetch_dashboard_analytics()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson('/core/general/dashboard_stats', [
            'active_account' => $user->active_account,
            'active_merchant' => $user->active_merchant,
        ]);

        // Assert the response
        $response->assertStatus(400)
            ->assertJsonStructure([
            'success',
            'message',
        ]);
    }

    /**
     * Test Failed Auth Fetch Dashboard Analytics
     *
     * @return void
     */
    public function test_failed_auth_fetch_dashboard_analytics()
    {
        // Call api endpoint
        $response = $this->getJson('/core/general/dashboard_stats', [
            'active_account' => '',
            'active_merchant' => '',
        ]);

        // Assert the response
        $response->assertStatus(401)
            ->assertJsonStructure([
            'success',
            'message',
        ]);
    }

    /**
     * Test Failed Validation Fetch Dashboard Analytics
     *
     * @return void
     */
    public function test_failed_validation_fetch_dashboard_analytics()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson('/core/general/dashboard_stats', [
            'active_account' => '',
            'active_merchant' => '',
        ]);

        // Assert the response
        $response->assertStatus(422)
            ->assertJsonStructure([
            'success',
            'errors',
        ]);
    }
}