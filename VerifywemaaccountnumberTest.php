<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\VirtualAccount;
use App\Models\Wallet;
use Tests\TestCase;

class VirtualAccountControllerVerifywemaaccountnumberTest extends TestCase
{
    use RefreshDatabase;

    public function test_valid_account_number_returns_valid_response()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a virtual account and wallet
        $account = VirtualAccount::factory()->create([
            'account_number' => '1234567890',
            'bank_name' => 'WEMA'
        ]);
        $wallet = Wallet::factory()->create(['id' => $account->wallet_id]);

        // Call api endpoint
        $response = $this->postJson("/verify/wema/accountnumber", ['account_no' => '1234567890']);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'status' => true,
            'account_name' => $account->account_name,
            'account_number' => $account->account_number
        ]);
    }

    public function test_invalid_account_number_returns_valid_response()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/verify/wema/accountnumber", ['account_no' => '1234567891']);

        // Assert the response
        $response->assertStatus(404);
        $response->assertJson([
            'status' => false,
            'account_number' => '1234567891'
        ]);
    }

    public function test_account_number_with_deactivated_or_pending_wallet_returns_valid_response()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a virtual account and wallet
        $account = VirtualAccount::factory()->create([
            'account_number' => '1234567890',
            'bank_name' => 'WEMA'
        ]);
        $wallet = Wallet::factory()->create([
            'id' => $account->wallet_id,
            'status' => 'DEACTIVATED'
        ]);

        // Call api endpoint
        $response = $this->postJson("/verify/wema/accountnumber", ['account_no' => '1234567890']);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'status' => true,
            'data' => [
                'account_number' => '1234567890',
                'status' => false
            ]
        ]);
    }

    public function test_account_number_without_authenticated_user_returns_valid_response()
    {
        // Call api endpoint
        $response = $this->postJson("/verify/wema/accountnumber", ['account_no' => '1234567891']);

        // Assert the response
        $response->assertStatus(401);
    }
}
