<?php
use App\Models\User;
use Tests\TestCase;
class ControllerVerifywematraxTest extends TestCase{
    public function test_with_valid_reference(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        $reference = 'ref123456';

        // Call api endpoint
        $response = $this->getJson("/verify/wema/tranx/{$reference}");

        // Assert the response
        $this->assertEquals(200, $response->status());
        $this->assertEquals('Success', $response->responseBody->status);
    }

    public function test_with_invalid_reference(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        $reference = 'invalidRef';

        // Call api endpoint
        $response = $this->getJson("/verify/wema/tranx/{$reference}");

        // Assert the response
        $this->assertEquals(401, $response->status());
        $this->assertEquals('Invalid Reference', $response->responseBody->status);
    }
}
