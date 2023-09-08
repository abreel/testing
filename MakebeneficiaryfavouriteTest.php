<?php
use App\Models\User;
use Tests\TestCase;
class BeneficiaryControllerMakebeneficiaryfavouriteTest extends TestCase
{
    public function test_make_beneficiary_favourite_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/api/v1/banking/beneficiary/add-to-favourite", [
            'id' => $user->id
        ]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure(['success', 'data']);
        $response->assertJson(['success' => true]);
        $this->assertArrayHasKey('favourite', $response->json()['data']);
    }

    public function test_make_beneficiary_favourite_validation_failure()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/api/v1/banking/beneficiary/add-to-favourite", [
            'id' => ''
        ]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson(['success' => false]);
        $this->assertArrayNotHasKey('favourite', $response->json()['data']);
    }

    public function test_make_beneficiary_favourite_failure()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/api/v1/banking/beneficiary/add-to-favourite", [
            'id' => $user->id
        ]);

        // Assert the response
        $response->assertStatus(500);
        $response->assertJson(['success' => false]);
        $this->assertArrayNotHasKey('favourite', $response->json()['data']);
    }
}