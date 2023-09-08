<?php
use App\Models\User;
use Tests\TestCase;
class ProviderControllerSendsinglefundTest extends TestCase{
    public function test_sendsinglefund_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/virtual/account/init/transfer", [
            'bankCode' => 'GTB',
            'accountNumber' => '0040345678',
            'accountName' => 'John Doe',
            'narration' => 'Test transaction',
            'amount' => '1000',
            'reference' => 'REF-001'
        ]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'status' => true,
            'data' => [
                'status' => 'success',
            ]
        ]);
    }

    public function test_sendsinglefund_failure(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/virtual/account/init/transfer", [
            'bankCode' => 'GTB',
            'accountNumber' => '0040345678',
            'accountName' => 'John Doe',
            'narration' => 'Test transaction',
            'amount' => '1000',
            'reference' => ''
        ]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'status' => false,
            'data' => [
                'status' => 'failure',
            ]
        ]);
    }

    public function test_sendsinglefund_bad_validation(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/virtual/account/init/transfer", [
            'bankCode' => 'GTB',
            'accountNumber' => '0040345678',
            'accountName' => 'John Doe',
            'narration' => 'Test transaction',
            'amount' => '1000',
            'reference' => 'REF-001'
        ]);

        // Assert the response
        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'The given data was invalid.'
        ]);
    }
}