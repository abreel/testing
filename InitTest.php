<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;

class PaymentControllerInitTest extends TestCase
{
    use RefreshDatabase;
    public function test_init_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/payment/", [
            'public_key' => 'required',
            'items' => [
                [
                    'revenue_head_code' => 'required'
                ]
            ],
            'customer' => [
                'email' => 'test@test.com'
            ],
            'order_id' => 'required|unique:transactions'
        ]);

        // Assert the response
        $response
            ->assertStatus(200)
            ->assertJsonStructure(['status', 'authorization_url', 'id']);
    }

    public function test_init_bad_key()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/payment/", [
            'public_key' => 'badkey',
            'items' => [
                [
                    'revenue_head_code' => 'required'
                ]
            ],
            'customer' => [
                'email' => 'test@test.com'
            ],
            'order_id' => 'required|unique:transactions'
        ]);

        // Assert the response
        $response
            ->assertStatus(404)
            ->assertJson(['status' => false, 'message' => 'Incorrect Key: Merchant Not Found']);
    }

    public function test_init_invalid_email()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/payment/", [
            'public_key' => 'required',
            'items' => [
                [
                    'revenue_head_code' => 'required'
                ]
            ],
            'customer' => [
                'email' => 'testtest.com'
            ],
            'order_id' => 'required|unique:transactions'
        ]);

        // Assert the response
        $response
            ->assertStatus(400)
            ->assertJson(['status' => false, 'message' => 'Invalid email (testtest.com)']);
    }

    public function test_init_invalid_amount()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/payment/", [
            'public_key' => 'required',
            'items' => [
                [
                    'revenue_head_code' => 'required'
                ]
            ],
            'customer' => [
                'email' => 'test@test.com'
            ],
            'amount' => 45,
            'order_id' => 'required|unique:transactions'
        ]);

        // Assert the response
        $response
            ->assertStatus(406)
            ->assertJson(['status' => false, 'message' => 'Error: Amount can not be less than 50']);
    }
}
