<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Account;
use Tests\TestCase;

class AccountControllerSwitchaccountTest extends TestCase
{
    use RefreshDatabase;

    public function test_switch_account_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a Account
        $account = Account::factory()->create([
            'user_id' => $user->id
        ]);

        // Call api endpoint
        $response = $this->postJson("/api/v1/core/accounts/switch-account", [
            'account_id' => $account->id
        ]);

        // Assert the response
        $response->assertOk();
        $response->assertJson([
            'success' => true
        ]);
        $response->assertJsonStructure([
            'success',
            'message',
            'id',
            'name',
            'merchant_id',
            'token',
            'userData' => [
                'ability'
            ]
        ]);
    }

    public function test_switch_account_failure()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/api/v1/core/accounts/switch-account", [
            'account_id' => 0
        ]);

        // Assert the response
        $response->assertNotOk();
        $response->assertJson([
            'success' => false
        ]);
        $response->assertJsonStructure([
            'success',
            'message'
        ]);
    }
}
