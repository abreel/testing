<?php
use App\Models\User;
use Tests\TestCase;

class UserComplianceControllerUploadprofileimageTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSuccessResponse()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson('/api/v1/core/general/update-profile-image', [
            'profile_image' => $this->getImageData()
        ]);

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Profile Image Uploaded Successfully'
        ]);
    }

    public function testValidationErrorResponse()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson('/api/v1/core/general/update-profile-image', []);

        $response->assertStatus(400);
        $response->assertExactJson([
            'success' => false,
            'message' => 'The profile image field is required.'
        ]);
    }

    public function testInactiveUserResponse()
    {
        $user = User::factory()->create([
            'status' => 'INACTIVE'
        ]);
        $this->actingAs($user);

        $response = $this->postJson('/api/v1/core/general/update-profile-image', [
            'profile_image' => $this->getImageData()
        ]);

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Profile Image Uploaded Successfully'
        ]);
    }

    private function getImageData()
    {
        // get image data from image
    }
}
