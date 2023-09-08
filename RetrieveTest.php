<?php
use App\Models\User;
use Tests\TestCase;
class ProviderControllerRetrieveTest extends TestCase
{
    public function successTest()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/provider/virtual-account/retrieve", [
            'account_reference' => '12345'
        ]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'account_reference',
                'balance',
                'currency',
            ]
        ]);
    }

    public function validationErrorTest()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/provider/virtual-account/retrieve", [
            'account_reference' => ''
        ]);

        // Assert the response
        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'account_reference'
        ]);
    }

    public function noAuthenticationTest()
    {
        // Call api endpoint
        $response = $this->postJson("/provider/virtual-account/retrieve", [
            'account_reference' => '12345'
        ]);

        // Assert the response
        $response->assertStatus(401);
    }
}