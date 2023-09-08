<?php
use App\Models\User;
use Tests\TestCase;
class DashboardAnalyticsControllerDashboardchartdataTest extends TestCase
{
    public function test_success_scenario(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson('/core/general/dashboard-chart', [
            'range' => 'monthly'
        ]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Chart data fetched successfully'
        ]);
    }

    public function test_failure_scenario(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson('/core/general/dashboard-chart', [
            'range' => ''
        ]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'Range is required'
        ]);
    }

    public function test_date_from_and_date_to(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson('/core/general/dashboard-chart', [
            'date_from' => '2020-01-01',
            'date_to' => '2020-02-01'
        ]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Chart data fetched successfully'
        ]);
    }
}