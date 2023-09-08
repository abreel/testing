<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;

class NotificationControllerGetallannouncementTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_announcements_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        $user->assignRole('admin');

        // Call api endpoint
        $response = $this->getJson("/announcements/get-all");
        
        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data' => [[
                'title',
                'message',
                'created_at',
                'status',
            ]]
        ]);
    }

    public function test_get_all_announcements_failure()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/announcements/get-all");
        
        // Assert the response
        $response->assertStatus(405);
        $response->assertJsonStructure(['success', 'message']);
    }

    public function test_get_all_announcements_bad_validation()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        $user->assignRole('admin');

        // Call api endpoint
        $response = $this->getJson("/announcements/get-all?perPage=test");
        
        // Assert the response
        $response->assertStatus(422);
        $response->assertJsonStructure(['success', 'message']);
    }

    public function test_get_all_announcements_expired()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        $user->assignRole('admin');

        // Call api endpoint
        $response = $this->getJson("/announcements/get-all?expired=true");
        
        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data' => [[
                'title',
                'message',
                'created_at',
                'status',
            ]]
        ]);
    }

    public function test_get_all_announcements_status_filter()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        $user->assignRole('admin');

        // Call api endpoint
        $response = $this->getJson("/announcements/get-all?status=Active");
        
        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data' => [[
                'title',
                'message',
                'created_at',
                'status',
            ]]
        ]);
    }
}