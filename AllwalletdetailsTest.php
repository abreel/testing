<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Wallet;
use Tests\TestCase;
class WalletControllerAllwalletdetailsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_admin_fetches_all_wallet_details()
    {
        // Create an admin user and authenticate
        $admin = User::factory()->create();
        $admin->roles()->attach(Role::where('name', 'admin')->first());
        $this->actingAs($admin);

        // Create some wallets
        $wallets = Wallet::factory()->count(5)->create();

        // Call the api endpoint
        $response = $this->getJson("/banking/all");

        // Assert the response
        $response->assertOk();
        $this->assertEquals($wallets->count(), $response->json('wallets')['total']);
    }

    /** @test */
    public function test_aggregator_fetches_all_wallet_details_from_accounts_under_it()
    {
        // Create an aggregator user and authenticate
        $aggregator = User::factory()->create();
        $aggregator->roles()->attach(Role::where('name', 'aggregator')->first());
        $this->actingAs($aggregator);

        // Create some wallets
        $aggregatorWallets = Wallet::factory()->count(3)->create();
        $nonAggregatorWallets = Wallet::factory()->count(5)->create();

        // Call the api endpoint
        $response = $this->getJson("/banking/all?aggeratorId={$aggregator->id}");

        // Assert the response
        $response->assertOk();
        $this->assertEquals($aggregatorWallets->count(), $response->json('wallets')['total']);
    }

    /** @test */
    public function test_non_admin_cannot_fetch_all_wallet_details()
    {
        // Create a non admin user and authenticate
        $nonAdmin = User::factory()->create();
        $this->actingAs($nonAdmin);

        // Call the api endpoint
        $response = $this->getJson("/banking/all");

        // Assert the response
        $response->assertStatus(403);
    }

    /** @test */
    public function test_validation_errors_are_returned_with_invalid_request()
    {
        // Create an admin user and authenticate
        $admin = User::factory()->create();
        $admin->roles()->attach(Role::where('name', 'admin')->first());
        $this->actingAs($admin);

        // Call the api endpoint with invalid request
        $response = $this->getJson("/banking/all?wallet_type=invalid_type");

        // Assert the response
        $response->assertStatus(422);
        $this->assertArrayHasKey('wallet_type', $response->json('errors'));
    }

    /** @test */
    public function test_admin_can_fetch_wallet_details_by_wallet_id()
    {
        // Create an admin user and authenticate
        $admin = User::factory()->create();
        $admin->roles()->attach(Role::where('name', 'admin')->first());
        $this->actingAs($admin);

        // Create a wallet
        $wallet = Wallet::factory()->create();

        // Call the api endpoint
        $response = $this->getJson("/banking/all?wallet_id={$wallet->id}");

        // Assert the response
        $response->assertOk();
        $this->assertEquals($wallet->id, $response->json('wallets')['id']);
    }

    /** @test */
    public function test_admin_can_fetch_wallet_details_by_search()
    {
        // Create an admin user and authenticate
        $admin = User::factory()->create();
        $admin->roles()->attach(Role::where('name', 'admin')->first());
        $this->actingAs($admin);

        // Create a wallet
        $wallet = Wallet::factory()->create([
            'name' => 'Wallet Name'
        ]);

        // Call the api endpoint
        $response = $this->getJson("/banking/all?search=Name");

        // Assert the response
        $response->assertOk();
        $this->assertEquals($wallet->id, $response->json('wallets')['id']);
    }

    /** @test */
    public function test_admin_can_fetch_wallet_details_by_date_range()
    {
        // Create an admin user and authenticate
        $admin = User::factory()->create();
        $admin->roles()->attach(Role::where('name', 'admin')->first());
        $this->actingAs($admin);

        // Create some wallets
        $wallets = Wallet::factory()->count(5)->create();

        // Call the api endpoint
        $response = $this->getJson("/banking/all?date_from=2020-11-01&date_to=2020-11-30");

        // Assert the response
        $response->assertOk();
        $this->assertEquals($wallets->count(), $response->json('wallets')['total']);
    }
}