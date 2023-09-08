<?php
use App\Models\Announcement;
use Tests\TestCase;

class NotificationControllerGetannouncementTest extends TestCase
{
    public function test_successful_get_announcement_request()
    {
        // Create an announcement
        $announcement = Announcement::factory()->create([
            'title' => 'Test Title',
            'message' => 'Test Message',
            'duration' => now()->addDays(2),
            'status' => 'active'
        ]);
        // Make a get request to the endpoint
        $response = $this->getJson('/announcements/get');
        // Assert that the response contains success and data
        $response->assertStatus(200);
        $response->assertJson(['success' => true, 'data' => $announcement]);
    }

    public function test_failed_get_announcement_request()
    {
        // Create an announcement
        Announcement::factory()->create([
            'title' => 'Test Title',
            'message' => 'Test Message',
            'duration' => now()->subDays(2),
            'status' => 'active'
        ]);
        // Make a get request to the endpoint
        $response = $this->getJson('/announcements/get');
        // Assert that the response contains success and no data
        $response->assertStatus(200);
        $response->assertJson(['success' => true, 'data' => null]);
    }
}
