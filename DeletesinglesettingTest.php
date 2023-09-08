<?php
namespace Tests\Feature;

use App\Models\User;
use App\Models\Setting;
use Tests\TestCase;

class CommercialControllerDeletesinglesettingTest extends TestCase
{
    /**
     * A basic test for deleteSingleSetting.
     *
     * @return void
     */
    public function testDeletesinglesettingSuccessful()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a setting
        $setting = Setting::factory()->create();

        // Send a request to the endpoint
        $response = $this->deleteJson("/setting/{$setting->id}");

        // Assert the response
        $response->assertStatus(200);
        $this->assertDatabaseMissing('settings', [
            'id' => $setting->id
        ]);
    }

    /**
     * A basic test for deleteSingleSetting failure.
     *
     * @return void
     */
    public function testDeletesinglesettingFailed()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Send a request to the endpoint
        $response = $this->deleteJson("/setting/123");

        // Assert the response
        $response->assertStatus(404);
        $response->assertExactJson(['message' => 'Error updating commercial']);
    }
}
