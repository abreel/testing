<?php
use App\Models\User;
use Tests\TestCase;
class DashboardAnalyticsControllerChart_dataTest extends TestCase
{
    public function test_chart_data_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/core/general/chart_data", ['days' => 7]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $response->assertJsonStructure(['success', 'data' => ['dates', 'amounts']]);
    }

    public function test_chart_data_bad_validation(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/core/general/chart_data");

        // Assert the response
        $response->assertStatus(422);
        $response->assertJson(['success' => false]);
        $response->assertJsonStructure(['success', 'message']);
    }

    public function test_chart_data_user_not_authenticated(){
        // Call api endpoint
        $response = $this->postJson("/core/general/chart_data", ['days' => 7]);

        // Assert the response
        $response->assertStatus(401);
        $response->assertJson(['success' => false]);
        $response->assertJsonStructure(['success', 'message']);
    }
}