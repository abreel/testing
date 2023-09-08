<?php
use App\Models\User;
use Tests\TestCase;
class MerchantControllerSearchTest extends TestCase{

    public function test_search_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/search", [
            'search' => 'user_query',
            'from_range' => '2020-08-01',
            'to_range' => '2020-09-01'
        ]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data'
        ]);
        $this->assertTrue($response['success']);
        $this->assertIsArray($response['data']);
    }

    public function test_search_failure()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/search", [
            'search' => 'user_query',
            'from_range' => '2020-08-01',
            'to_range' => '2020-08-01'
        ]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJsonStructure([
            'error'
        ]);
        $this->assertFalse($response['success']);
        $this->assertIsString($response['error']);
    }

    public function test_search_unauthorized()
    {
        // Call api endpoint
        $response = $this->getJson("/search", [
            'search' => 'user_query',
            'from_range' => '2020-08-01',
            'to_range' => '2020-09-01'
        ]);

        // Assert the response
        $response->assertStatus(401);
        $response->assertJsonStructure([
            'error'
        ]);
        $this->assertFalse($response['success']);
        $this->assertIsString($response['error']);
    }

    public function test_search_bad_request()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/search", [
            'search' => 'user_query',
            'from_range' => '2020-08-01'
        ]);

        // Assert the response
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors'
        ]);
        $this->assertFalse($response['success']);
        $this->assertIsArray($response['errors']);
    }

}