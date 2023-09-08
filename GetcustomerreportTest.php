<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;
class ReportControllerGetcustomerreportTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_can_get_report_with_no_parameters()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/reports/customer");

        // Assert the response
        $response->assertStatus(200)
            ->assertJsonCount(10)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'customer_id', 
                        'merchant_id', 
                        'total_transaction_count',
                        'total_transaction'
                    ]
                ],
                'links' => [],
                'meta' => [],
            ]);
    }

    public function test_can_get_report_with_per_page_parameter()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/reports/customer?perPage=20");

        // Assert the response
        $response->assertStatus(200)
            ->assertJsonCount(20)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'customer_id', 
                        'merchant_id', 
                        'total_transaction_count',
                        'total_transaction'
                    ]
                ],
                'links' => [],
                'meta' => [],
            ]);
    }

    public function test_can_get_report_with_search_parameter()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/reports/customer?search=John");

        // Assert the response
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'customer_id', 
                        'merchant_id', 
                        'total_transaction_count',
                        'total_transaction'
                    ]
                ],
                'links' => [],
                'meta' => [],
            ]);
    }

    public function test_can_get_report_with_date_from_parameter()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/reports/customer?date_from=2020-01-01");

        // Assert the response
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'customer_id', 
                        'merchant_id', 
                        'total_transaction_count',
                        'total_transaction'
                    ]
                ],
                'links' => [],
                'meta' => [],
            ]);
    }

    public function test_can_get_report_with_date_to_parameter()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/reports/customer?date_to=2020-01-31");

        // Assert the response
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'customer_id', 
                        'merchant_id', 
                        'total_transaction_count',
                        'total_transaction'
                    ]
                ],
                'links' => [],
                'meta' => [],
            ]);
    }

    public function test_can_get_report_with_customer_id_parameter()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/reports/customer?customer_id=1");

        // Assert the response
        $response->assertStatus(200)
            ->assertJsonStructure([
                'customer_id', 
                'merchant_id', 
                'total_transaction_count',
                'total_transaction'
            ]);
    }

    public function test_failure_if_request_is_invalid()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/reports/customer?invalid=param");

        // Assert the response
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'invalid'
            ]);
    }
}