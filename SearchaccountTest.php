<?php
use App\Models\User;
use Tests\TestCase;
class AccountControllerSearchaccountTest extends TestCase{
    public function test_search_account_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $search = 'Test';
        $response = $this->getJson("/api/search-account/{$search}");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'user_id']
            ]
        ]);
    }

    public function test_search_account_empty_results(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $search = 'EmptySearch';
        $response = $this->getJson("/api/search-account/{$search}");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['data' => []]);
    }

    public function test_search_account_without_parameters(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/api/search-account/");

        // Assert the response
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['search']);
    }

    public function test_search_account_not_authenticated(){
        // Call api endpoint
        $search = 'Test';
        $response = $this->getJson("/api/search-account/{$search}");

        // Assert the response
        $response->assertStatus(401);
        $response->assertJson(['message' => 'Unauthenticated.']);
    }
}