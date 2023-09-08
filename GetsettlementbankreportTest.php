<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;

class ReportControllerGetsettlementbankreportTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_settlement_bank_report_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/reports/settlement-bank");

        // Assert the response
        $response->assertStatus(200);
        $this->assertIsObject($response->json());
    }

    public function test_get_settlement_bank_report_with_per_page_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/reports/settlement-bank?perPage=20");

        // Assert the response
        $response->assertStatus(200);
        $this->assertIsObject($response->json());
    }

    public function test_get_settlement_bank_report_with_search_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/reports/settlement-bank?search=test");

        // Assert the response
        $response->assertStatus(200);
        $this->assertIsObject($response->json());
    }

    public function test_get_settlement_bank_report_with_date_from_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/reports/settlement-bank?date_from=2020-09-09");

        // Assert the response
        $response->assertStatus(200);
        $this->assertIsObject($response->json());
    }

    public function test_get_settlement_bank_report_with_date_to_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/reports/settlement-bank?date_to=2020-09-09");

        // Assert the response
        $response->assertStatus(200);
        $this->assertIsObject($response->json());
    }

    public function test_get_settlement_bank_report_with_merchant_id_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/reports/settlement-bank?merchant_id=1");

        // Assert the response
        $response->assertStatus(200);
        $this->assertIsObject($response->json());
    }

    public function test_get_settlement_bank_report_with_page_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/reports/settlement-bank?page=1");

        // Assert the response
        $response->assertStatus(200);
        $this->assertIsObject($response->json());
    }

    public function test_get_settlement_bank_report_with_invalid_page_failure()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/reports/settlement-bank?page=0");

        // Assert the response
        $response->assertStatus(400);
        $this->assertEquals('Invalid page.', $response->json()['message']);
    }

    public function test_get_settlement_bank_report_without_authentication_failure()
    {
        // Call api endpoint
        $response = $this->getJson("/reports/settlement-bank");

        // Assert the response
        $response->assertStatus(401);
    }
}
