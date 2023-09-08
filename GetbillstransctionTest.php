<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;

class BillsControllerGetbillstransctionTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_bills_transaction_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/bills/transactions");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data'
        ]);
    }

    public function test_get_bills_transaction_invalid_per_page()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/bills/transactions?perPage=string");

        // Assert the response
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'perPage'
            ]
        ]);
    }

    public function test_get_bills_transaction_admin_manage_all()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/bills/transactions?status=1");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data'
        ]);
    }

    public function test_get_bills_transaction_invalid_product()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/bills/transactions?product=invalidProduct");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data'
        ]);
    }

    public function test_get_bills_transaction_invalid_biller()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/bills/transactions?biller=invalidBiller");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data'
        ]);
    }

    public function test_get_bills_transaction_invalid_category()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/bills/transactions?category=invalidCategory");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data'
        ]);
    }

    public function test_get_bills_transaction_invalid_search()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/bills/transactions?search=invalidSearch");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data'
        ]);
    }

    public function test_get_bills_transaction_invalid_date_from()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/bills/transactions?date_from=invalidDate");

        // Assert the response
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'date_from'
            ]
        ]);
    }

    public function test_get_bills_transaction_invalid_date_to()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/bills/transactions?date_to=invalidDate");

        // Assert the response
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'date_to'
            ]
        ]);
    }
}