<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\VirtualAccount;
use App\Models\Wallet;
use App\Models\WalletRequest;
use App\Models\WalletTransaction;
use Tests\TestCase;

class WalletRequestControllerGetwalletrequestsforauthuserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that an authenticated user
     * can get wallet requests
     * @return void
     */
    public function testUserCanGetWalletRequests()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $userAccountNumber = VirtualAccount::factory()->create(['wallet_id' => function () use ($user) {
            return Wallet::factory()->create(['account_id' => $user->active_account]);
        }]);
        WalletRequest::factory()->create([
            'status' => WalletTransaction::$status["pending"],
            'dbaccount_no' => $userAccountNumber->account_number
        ]);

        $response = $this->getJson("/transfer/request/get");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data',
        ]);
    }

    /**
     * Test that an authenticated user
     * cannot get wallet requests if
     * doesn't have an active account
     * @return void
     */
    public function testUserCannotGetWalletRequestsWithoutActiveAccount()
    {
        $user = User::factory()->create(['active_account' => null]);
        $this->actingAs($user);

        $response = $this->getJson("/transfer/request/get");

        $response->assertStatus(400);
        $response->assertJsonStructure([
            'success',
            'message',
        ]);
    }

    /**
     * Test that an authenticated user
     * cannot get wallet requests if
     * doesn't have a valid virtual account
     * @return void
     */
    public function testUserCannotGetWalletRequestsWithInvalidVirtualAccount()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->getJson("/transfer/request/get");

        $response->assertStatus(400);
        $response->assertJsonStructure([
            'success',
            'message',
        ]);
    }

    /**
     * Test that an unauthenticated user
     * cannot get wallet requests
     * @return void
     */
    public function testUserCannotGetWalletRequestsWithoutAuthentication()
    {
        $response = $this->getJson("/transfer/request/get");

        $response->assertStatus(401);
    }
}
