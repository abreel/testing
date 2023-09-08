<?php
use App\Models\User;
use Tests\TestCase;
class DemoLiveControllerOnboardTest extends TestCase
{
    /** @test */
    public function it_validates_inputs_for_onboarding()
    {
        $this->postJson('/onboard', [
            'first_name' => '',
            'last_name' => '',
            'user_type' => '',
            'email' => '',
            'password' => '',
            'business_name' => '',
            'phone' => '',
            'bvn' => '',
            'bank_code' => '',
            'account_no' => '',
            'account_name' => '',
            'settlement_bank_title' => '',
            'bank_name' => '',
            'settlement_email' => ''
        ])
        ->assertStatus(400)
        ->assertJson([
            'success' => false,
            'message' => 'The first name field is required.'
        ]);
    }

    /** @test */
    public function it_rejects_registration_if_email_already_exists()
    {
        User::factory()->create([
            'email' => 'test@example.com'
        ]);

        $this->postJson('/onboard', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'user_type' => 'MERCHANT',
            'email' => 'test@example.com',
            'password' => 'password',
            'business_name' => 'Test Business',
            'phone' => '12345678901',
            'bvn' => '12345678901',
            'bank_code' => '123',
            'account_no' => '1234567',
            'account_name' => 'John Doe',
            'settlement_bank_title' => 'Test Bank',
            'bank_name' => 'Test Bank',
            'settlement_email' => 'test@example.com',
        ])
        ->assertStatus(400)
        ->assertJson([
            'success' => false,
            'message' => 'The email has already been taken.'
        ]);
    }

    /** @test */
    public function it_successfully_registers_a_merchant()
    {
        $this->postJson('/onboard', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'user_type' => 'MERCHANT',
            'email' => 'test@example.com',
            'password' => 'password',
            'business_name' => 'Test Business',
            'phone' => '12345678901',
            'bvn' => '12345678901',
            'bank_code' => '123',
            'account_no' => '1234567',
            'account_name' => 'John Doe',
            'settlement_bank_title' => 'Test Bank',
            'bank_name' => 'Test Bank',
            'settlement_email' => 'test@example.com',
        ])
        ->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Merchant Onboarding Successful',
        ]);
    }
}