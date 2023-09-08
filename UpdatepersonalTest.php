<?php
use App\Models\User;
use Tests\TestCase;
class ComplianceControllerUpdatepersonalTest extends TestCase{
    public function test_user_update_personal_info_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/update-personal", [
            'phone' => '09070000000',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'bvn' => ''
        ]);

        // Assert the response
        $response->assertOk();
        $response->assertJson(['success' => true, 'message' => 'Personal Information Updated successfully!']);
    }

    public function test_user_update_personal_info_without_required_field()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/update-personal", [
            'phone' => '09070000000',
            'first_name' => 'John',
            'bvn' => ''
        ]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson(['success' => false, 'message' => 'The last name field is required.']);
    }

    public function test_user_update_personal_info_with_phone_below_10_char()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/update-personal", [
            'phone' => '0907000',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'bvn' => ''
        ]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson(['success' => false, 'message' => 'The phone must be at least 10 characters.']);
    }
}