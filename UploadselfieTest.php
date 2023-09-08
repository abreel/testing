<?php
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
class ComplianceControllerUploadselfieTest extends TestCase{
    public function test_upload_selfie_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/upload-selfie", [
            'selfie_with_card' => UploadedFile::fake()->image('selfie.jpg')
        ]);
    
        // Assert the response
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Selfie updated successfully'
            ]);
    }

    public function test_upload_selfie_failure(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/upload-selfie");
    
        // Assert the response
        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'The selfie with card field is required.'
            ]);
    }

}