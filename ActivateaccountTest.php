<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Merchant;
use App\Models\Account;
use Tests\TestCase;

class AccountControllerActivateaccountTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_fails_when_the_account_does_not_exist()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson('/activate/non-existent-account-id');

        // Assert the response
        $response->assertStatus(404);
        $response->assertJson(['success' => false, 'message' => 'Account Not Found!']);
    }

    /** @test */
    public function it_creates_a_default_revenue_head()
    {
        // Create a merchant and an account
        $merchant = Merchant::factory()->create();
        $account = Account::factory()->create([
            'user_id' => $merchant->user_id,
            'merchant_id' => $merchant->id,
        ]);

        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/activate/{$account->id}");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['success' => true, 'message' => 'You have successfully activated this Account!']);
        $this->assertDatabaseHas('revenue_heads', [
            'settlement_bank_id' => $merchant->settlement_bank_id,
        ]);
    }

    /** @test */
    public function it_creates_a_default_wallet()
    {
        // Create a merchant and an account
        $merchant = Merchant::factory()->create();
        $account = Account::factory()->create([
            'user_id' => $merchant->user_id,
            'merchant_id' => $merchant->id,
        ]);

        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/activate/{$account->id}");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['success' => true, 'message' => 'You have successfully activated this Account!']);
        $this->assertDatabaseHas('wallets', [
            'wallet_type' => $account->type,
            'account_id' => $account->id,
            'personal_id' => $account->user_id,
            'merchant_id' => $merchant->id,
            'settlement_bank_id' => $merchant->settlement_bank_id,
            'name' => $account->name,
            'description' => 'Default Wallet',
        ]);
    }

    /** @test */
    public function it_updates_the_account_status_to_activated()
    {
        // Create a merchant and an account
        $merchant = Merchant::factory()->create();
        $account = Account::factory()->create([
            'user_id' => $merchant->user_id,
            'merchant_id' => $merchant->id,
        ]);

        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/activate/{$account->id}");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['success' => true, 'message' => 'You have successfully activated this Account!']);
        $this->assertDatabaseHas('accounts', [
            'id' => $account->id,
            'status' => 'ACTIVATED',
        ]);
    }

    /** @test */
    public function it_creates_a_notification_for_the_user()
    {
        // Create a merchant and an account
        $merchant = Merchant::factory()->create();
        $account = Account::factory()->create([
            'user_id' => $merchant->user_id,
            'merchant_id' => $merchant->id,
        ]);

        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/activate/{$account->id}");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['success' => true, 'message' => 'You have successfully activated this Account!']);
        $this->assertDatabaseHas('notifications', [
            'user_id' => $merchant->user_id,
            'account_id' => $account->id,
            'message' => 'Account Activation',
        ]);
    }

    /** @test */
    public function it_sends_a_push_notification_to_the_user()
    {
        // Create a merchant and an account
        $merchant = Merchant::factory()->create();
        $account = Account::factory()->create([
            'user_id' => $merchant->user_id,
            'merchant_id' => $merchant->id,
        ]);

        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/activate/{$account->id}");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['success' => true, 'message' => 'You have successfully activated this Account!']);
    }
}
