<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Merchant;
use App\Models\Account;
use Tests\TestCase;

class AccountControllerDemoactivateaccountTest extends TestCase
{
    use RefreshDatabase;

    // Test success case
    public function testSuccessDemoActivateAccount()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a merchant
        $merchant = Merchant::factory()->create();

        // Create an account
        $account = Account::factory()->create([
            'account_id' => $merchant->account_id,
            'user_id' => $merchant->user_id,
            'type' => 'Default',
            'name' => $merchant->name,
            'status' => 'INACTIVE',
        ]);

        // Call demoActivate api endpoint
        $response = $this->postJson("/demo-activate/{$account->id}");

        // Assert the response
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'You have successfully activated this Account!'
            ]);
    }

    // Test failure case
    public function testFailedDemoActivateAccount()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call demoActivate api endpoint
        $response = $this->postJson("/demo-activate/{$account->id}");

        // Assert the response
        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'Account Not Found!'
            ]);
    }

    // Test bad validation case
    public function testBadValidationDemoActivateAccount()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call demoActivate api endpoint
        $response = $this->postJson("/demo-activate/{$account->id}", [
            'wallet_type' => '',
            'account_id' => '',
            'personal_id' => '',
            'merchant_id' => '',
            'settlement_bank_id' => '',
            'name' => '',
            'description' => ''
        ]);

        // Assert the response
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'wallet_type',
                'account_id',
                'personal_id',
                'merchant_id',
                'settlement_bank_id',
                'name',
                'description'
            ]);
    }
}
