<?php
use App\Models\User;
use Tests\TestCase;
class ProvidersControllerStoreTest extends TestCase
{
    /**
     * Test Success
     *
     * @return void
     */
    public function test_store_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/providers", [
            'name' => 'My Provider',
            'email' => 'myprovider@example.com',
            'address' => 'My Address'
        ]);

        // Assert the response
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => ['name', 'email', 'address'],
            'message'
        ]);
    }

    /**
     * Test Validation
     *
     * @return void
     */
    public function test_store_validation()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/providers", []);

        // Assert the response
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'error'
        ]);
    }
    
    /**
     * Test Failure
     *
     * @return void
     */
    public function test_store_failure()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/providers", [
            'name' => 'My Provider',
            'email' => 'invalid-email',
            'address' => 'My Address'
        ]);

        // Assert the response
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'error'
        ]);
    }

}