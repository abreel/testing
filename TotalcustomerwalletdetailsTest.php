<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Account;
use App\Models\AggregatorCustomer;
use Tests\TestCase;
class WalletControllerTotalcustomerwalletdetailsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_success_with_wallet_details_for_authenticated_admin_user_without_date()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/banking/customers/wallet-stat");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $response->assertJsonStructure(['wallet_stat' => ['balance', 'total_credit', 'total_debit']]);
    }

    /** @test */
    public function it_returns_success_with_wallet_details_for_authenticated_admin_user_with_date()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/banking/customers/wallet-stat?date_from=2020-01-01&date_to=2020-01-31");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $response->assertJsonStructure(['wallet_stat' => ['balance', 'total_credit', 'total_debit']]);
    }    

    /** @test */
    public function it_returns_success_with_wallet_details_for_authenticated_admin_user_with_aggregator_id()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/banking/customers/wallet-stat?aggregator_id=1");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $response->assertJsonStructure(['wallet_details' => ['balance', 'total_credit', 'total_debit']]);
    }

    /** @test */
    public function it_returns_success_with_wallet_details_for_authenticated_non_admin_user_without_date()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/banking/customers/wallet-stat");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $response->assertJsonStructure(['wallet_details' => ['balance', 'total_credit', 'total_debit']]);
    }

    /** @test */
    public function it_returns_success_with_wallet_details_for_authenticated_non_admin_user_with_date()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        $account = Account::factory()->create(['user_id' => $user->id]);
        $aggregator = AggregatorCustomer::factory()->create(['aggregator_id' => $account->aggregator_id]);

        // Call api endpoint
        $response = $this->getJson("/banking/customers/wallet-stat?date_from=2020-01-01&date_to=2020-01-31");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $response->assertJsonStructure(['wallet_details' => ['balance', 'total_credit', 'total_debit']]);
    }

    /** @test */
    public function it_returns_unauthorized_response_for_unauthenticated_user(){
        // Call api endpoint
        $response = $this->getJson("/banking/customers/wallet-stat");

        // Assert the response
        $response->assertStatus(401);
        $response->assertJson(['message' => 'Unauthenticated.']);
    }
}