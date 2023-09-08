<?php
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
class systemSettingsTest extends TestCase{
    // Successful system settings update test
    public function test_system_settings_update_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        $merchantid = Auth::user()->active_merchant;

        // Set data for request
        $data = [
            'vsystem' => 'test',
            'settlement_duration' => 'test'
        ];

        // Call api endpoint
        $response = $this->postJson("/api/v1/core/merchant/{$merchantid}/system/settings", $data);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => "System settings Updated successfully!"
        ]);
    }

    // Unsuccessful system settings update test
    public function test_system_settings_update_failure(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        $merchantid = Auth::user()->active_merchant;

        // Set data for request
        $data = [
            'vsystem' => '',
            'settlement_duration' => ''
        ];

        // Call api endpoint
        $response = $this->postJson("/api/v1/core/merchant/{$merchantid}/system/settings", $data);

        // Assert the response
        $response->assertStatus(422);
        $response->assertJson([
            'success' => false,
            'message' => "Error updating system settings!"
        ]);
    }

    // Unauthenticated system settings update test
    public function test_system_settings_update_unauthenticated(){
        $merchantid = Auth::user()->active_merchant;

        // Set data for request
        $data = [
            'vsystem' => 'test',
            'settlement_duration' => 'test'
        ];

        // Call api endpoint
        $response = $this->postJson("/api/v1/core/merchant/{$merchantid}/system/settings", $data);

        // Assert the response
        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Unauthenticated.'
        ]);
    }

    // System settings get test
    public function test_system_settings_get(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        $merchantid = Auth::user()->active_merchant;

        // Call api endpoint
        $response = $this->getJson("/api/v1/core/merchant/{$merchantid}/system/settings");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'vsystem' => '',
            'settlement_duration' => ''
        ]);
    }
}