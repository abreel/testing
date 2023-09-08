<?php
use App\Models\User;
use App\Models\SettlementBank;
use App\Models\Merchant;
use App\Models\Account;
use App\Models\Wallet;
    use Tests\TestCase;
    class SettlementBankControllerUpdatesettlementbankwalletTest extends TestCase
    {
        public function test_update_settlement_bank_wallet_success(){
            // Create a user and authenticate
            $user = User::factory()->create();
            $this->actingAs($user);

            // Create settlement banks
            $settlementBanks = SettlementBank::factory()->count(3)->create();
            $settlementBank = $settlementBanks->first();

            // Create merchant
            $merchant = Merchant::factory()->create();
            $merchant->account_id = $merchant->id;
            $merchant->save();
            $settlementBank->merchant_id = $merchant->id;
            $settlementBank->save();

            // Create account 
            $account = Account::factory()->create();
            $merchant->account_id = $account->id;
            $merchant->save();
            $account->wallet_id = $account->id;
            $account->save();

            // Create wallet
            $wallet = Wallet::factory()->create();
            $wallet->settlement_bank_id = $settlementBank->id;
            $wallet->save();

            // Call api endpoint
            $response = $this->postJson("/api/v1/update-settlement-bank/{$settlementBank->id}");

            // Assert the response
            $response->assertStatus(200);
            $response->assertJson(['success' => true]);
            $response->assertJson(['message' => 'Settlement bank Updated Successfully']);
        }

        public function test_update_settlement_bank_wallet_bad_validation(){
            // Create a user and authenticate
            $user = User::factory()->create();
            $this->actingAs($user);

            // Call api endpoint
            $response = $this->postJson("/api/v1/update-settlement-bank/");

            // Assert the response
            $response->assertStatus(422);
            $response->assertJson(['success' => false]);
            $response->assertJson(['message' => 'Validation failed']);
        }
    }