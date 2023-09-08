<?php
use App\Models\User;
use Tests\TestCase;
class WalletControllerCustomersTest extends TestCase{

    public function test_customer_registration_request_with_valid_data()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/banking/customers", [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com'
        ]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john.doe@example.com'
            ]
        ]);
    }

    public function test_customer_registration_request_with_invalid_data()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/banking/customers", [
            'first_name' => '',
            'last_name' => '',
            'email' => 'invalid'
        ]);

        // Assert the response
        $response->assertStatus(422);
        $response->assertJson([
            'success' => false,
            'message' => 'The given data was invalid.',
            'errors' => [
                'first_name' => [
                    'The first name field is required.'
                ],
                'last_name' => [
                    'The last name field is required.'
                ],
                'email' => [
                    'The email must be a valid email address.'
                ]
            ]
        ]);
    }

    public function test_customer_data_fetching()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/banking/customers");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => [
                'id',
                'first_name',
                'last_name',
                'email'
            ]
        ]);
    }

}