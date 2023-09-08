<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Commercial;
use Tests\TestCase;

class ComplianceControllerAllcommercialsTest extends TestCase
{
    use RefreshDatabase;

    public function test_allCommercials_with_active_status()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a commercial
        Commercial::factory()->create([
            'status' => 'ACTIVE'
        ]);

        // Call api endpoint
        $response = $this->getJson('/all-commercials');

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                [
                    'name',
                    'id'
                ]
            ]
        ]);
    }

    public function test_allCommercials_with_inactive_status()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a commercial
        Commercial::factory()->create([
            'status' => 'INACTIVE'
        ]);

        // Call api endpoint
        $response = $this->getJson('/all-commercials');

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonCount(0, 'data');
    }
}