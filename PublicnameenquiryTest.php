<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\VirtualAccount;
use App\Models\Wallet;
use App\Models\Bank;
use Tests\TestCase;
class ProviderControllerPublicnameenquiryTest extends TestCase{
    use RefreshDatabase;

    public function test_public_name_enquiry_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Set up a virtual account
        $virtualAccount = VirtualAccount::factory()->create();
        $wallet = Wallet::factory()->create(['id' => $virtualAccount->wallet_id]);

        // Set up a bank
        $bank = Bank::factory()->create(['code' => '001']);

        // Call api endpoint
        $response = $this->postJson("/provider/disbursement/name-enquiry", [
            'bank_code' => '001',
            'account_no' => $virtualAccount->account_number
        ]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['status' => true]);
        $response->assertJsonStructure(['data' => ['status', 'bank_code', 'account_name', 'account_number', 'bank_name', 'bank_shortname']]);
    }

    public function test_public_name_enquiry_failure_account_not_verified()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Set up a virtual account
        $virtualAccount = VirtualAccount::factory()->create();
        $wallet = Wallet::factory()->create(['id' => $virtualAccount->wallet_id, 'status' => 'DEACTIVATED']);

        // Set up a bank
        $bank = Bank::factory()->create(['code' => '001']);

        // Call api endpoint
        $response = $this->postJson("/provider/disbursement/name-enquiry", [
            'bank_code' => '001',
            'account_no' => $virtualAccount->account_number
        ]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['status' => true]);
        $response->assertJson(['data' => ['status' => 0, 'account_name' => 'Account Could not  be verified']]);
    }

    public function test_public_name_enquiry_failure_invalid_bank_code()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Set up a bank
        $bank = Bank::factory()->create(['code' => '001']);

        // Call api endpoint
        $response = $this->postJson("/provider/disbursement/name-enquiry", [
            'bank_code' => '002',
            'account_no' => '1234567890'
        ]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJsonStructure(['message']);
    }

    public function test_public_name_enquiry_failure_bad_validation()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/provider/disbursement/name-enquiry", [
            'bank_code' => '123456',
            'account_no' => '12345'
        ]);

        // Assert the response
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['bank_code', 'account_no']);
    }
}