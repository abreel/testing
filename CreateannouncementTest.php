<?php
use App\Models\User;
use Tests\TestCase;
class NotificationControllerCreateannouncementTest extends TestCase{
    public function test_create_an_announcement_as_an_admin_with_valid_data_and_with_popup_type_and_duration()
    {
        // Create an admin user and authenticate
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        // Call api endpoint with valid data
        $data = (object) ["title" => "New Announcement", "body" =>  "This is a test announcement."];
        $duration = 5;
        $response = $this->postJson("/annoucements/create", ['title' => $data->title, 'body' => $data->body, 'type' => 'popup', 'duration' => $duration]);

        // Assert the response
        $response->assertStatus(201);
        $response->assertExactJson(['success' => true, 'message' => "Announcement sent"]);
    }

    public function test_create_an_announcement_as_an_admin_with_valid_data_and_without_duration_with_popup_type()
    {
        // Create an admin user and authenticate
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        // Call api endpoint with valid data
        $data = (object) ["title" => "New Announcement", "body" =>  "This is a test announcement."];
        $response = $this->postJson("/annoucements/create", ['title' => $data->title, 'body' => $data->body, 'type' => 'popup']);

        // Assert the response
        $response->assertStatus(400);
        $response->assertExactJson(['success' => false, 'message' => "The duration field is required"]);
    }

    public function test_create_an_announcement_as_an_admin_with_invalid_data_and_with_popup_type_and_duration()
    {
        // Create an admin user and authenticate
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        // Call api endpoint with valid data
        $data = (object) ["title" => "", "body" =>  "This is a test announcement."];
        $duration = 5;
        $response = $this->postJson("/annoucements/create", ['title' => $data->title, 'body' => $data->body, 'type' => 'popup', 'duration' => $duration]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertExactJson(['success' => false, 'message' => "The title field is required"]);
    }

    public function test_create_an_announcement_as_a_non_admin_user()
    {
        // Create an non-admin user and authenticate
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user);

        // Call api endpoint
        $data = (object) ["title" => "New Announcement", "body" =>  "This is a test announcement."];
        $response = $this->postJson("/annoucements/create", ['title' => $data->title, 'body' => $data->body, 'type' => 'popup']);

        // Assert the response
        $response->assertStatus(405);
        $response->assertExactJson(['success' => false, 'message' => "Insufficient access"]);
    }

}