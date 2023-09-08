


<?php
use Tests\TestCase;
class MerchantControllerAccountoptionTest extends TestCase{
    public function accountOptionTest(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/account/option", [
            'enable_tr_charge_on_customer' => true,
            'enable_customer_email_notification' => true,
            'enable_merchant_email_notification' => true,
            'enable_TwoFactor' => true,
            'payout_method' => 'daily',
            'enable_card_payment' => true,
            'enable_transfer_payment' => true
        ]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Account option updated successfully'
        ]);
    }
    
    public function accountOptionFailedTest(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/account/option", [
            'enable_tr_charge_on_customer' => true,
            'enable_customer_email_notification' => true,
            'enable_merchant_email_notification' => true,
            'enable_TwoFactor' => true,
            'payout_method' => 'invalid',
            'enable_card_payment' => true,
            'enable_transfer_payment' => true
        ]);

        // Assert the response
        $response->assertStatus(422);
        $response->assertJson([
            'success' => false,
            'message' => 'Unable to update account option'
        ]);
    }
    
    public function accountOptionUnauthenticatedTest(){
        // Call api endpoint
        $response = $this->postJson("/account/option", [
            'enable_tr_charge_on_customer' => true,
            'enable_customer_email_notification' => true,
            'enable_merchant_email_notification' => true,
            'enable_TwoFactor' => true,
            'payout_method' => 'daily',
            'enable_card_payment' => true,
            'enable_transfer_payment' => true
        ]);

        // Assert the response
        $response->assertStatus(401);
    }
}