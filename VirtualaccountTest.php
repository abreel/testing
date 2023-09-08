<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Customer;
use Tests\TestCase;
class CustomerControllerVirtualaccountTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_success_virtual_account_creation()
    {   
        // Create a customer
        $customer = Customer::factory()->create();

        // Make an api call
        $response = $this->postJson("/create/virtual-account/standard/{$customer->id}");
        
        // Assert the response
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'vbank_data',
            ]
        ]);
        $this->assertDatabaseHas('customers', [
            'id' => $customer->id
        ]);
    }

    public function test_failure_virtual_account_creation()
    {
        // Create a customer
        $customer = Customer::factory()->create();

        // Make an api call
        $response = $this->postJson("/create/virtual-account/standard/{$customer->id}");
        
        // Assert the response
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message'
        ]);
        $this->assertDatabaseMissing('customers', [
            'id' => $customer->id
        ]);
    }

    public function test_bad_validation_virtual_account_creation()
    {
        // Create a customer
        $customer = Customer::factory()->create();

        // Make an api call
        $response = $this->postJson("/create/virtual-account/standard/{$customer->id}");
        
        // Assert the response
        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'firstname', 'lastname', 'phone', 'email',
        ]);
        $this->assertDatabaseMissing('customers', [
            'id' => $customer->id
        ]);
    }
}