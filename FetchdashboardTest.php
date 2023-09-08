<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;
class DashboardAnalyticsControllerFetchdashboardTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function test_dashboard_should_fetch_data_with_range()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint with range
        $response = $this->getJson("/core/general/dashboard-stat2", ['range' => 'monthly']);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'total_customer',
                'total_transaction',
                'total_revenue',
                'total_wallet',
                'recent_transactions'
            ],
            'analytics' => [
                'total_payment_today',
                'total_payment_last_7days',
                'total_payment_last_1months'
            ]
        ]);
    }

    /**
     * @test
     */
    public function test_dashboard_should_fetch_data_with_date_from_and_date_to()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint with date from and date to
        $response = $this->getJson("/core/general/dashboard-stat2", [
            'date_from' => '2021-06-01',
            'date_to' => '2021-06-30'
        ]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'total_customer',
                'total_transaction',
                'total_revenue',
                'total_wallet',
                'recent_transactions'
            ],
            'analytics' => [
                'total_payment_today',
                'total_payment_last_7days',
                'total_payment_last_1months'
            ]
        ]);
    }

    /**
     * @test
     */
    public function test_dashboard_should_return_error_when_no_parameter()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint with no parameters
        $response = $this->getJson("/core/general/dashboard-stat2");

        // Assert the response
        $response->assertStatus(400);
        $response->assertJsonStructure([
            'success',
            'message'
        ]);
    }

    /**
     * @test
     */
    public function test_dashboard_should_fetch_data_for_admin_user()
    {
        // Create an admin user and authenticate
        $user = User::factory()
            ->role('admin')
            ->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->getJson("/core/general/dashboard-stat2");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'total_customer',
                'total_transaction',
                'total_revenue',
                'total_wallet',
                'recent_transactions'
            ],
            'analytics' => [
                'total_payment_today',
                'total_payment_last_7days',
                'total_payment_last_1months'
            ]
        ]);
    }

    /**
     * @test
     */
    public function test_dashboard_should_fetch_data_for_merchant_user()
    {
        // Create a merchant user and authenticate
        $user = User::factory()
            ->role('merchant')
            ->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->getJson("/core/general/dashboard-stat2");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'total_customer',
                'total_transaction',
                'total_revenue',
                'total_wallet',
                'recent_transactions'
            ],
            'analytics' => [
                'total_payment_today',
                'total_payment_last_7days',
                'total_payment_last_1months'
            ]
        ]);
    }
}