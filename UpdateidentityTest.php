<?php
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
class ComplianceControllerUpdateidentityTest extends TestCase
{
    public function test_validation_fails_with_invalid_input()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/update-identity");
        
        // Assert the response
        $response->assertStatus(400)
        ->assertJson(['success' => false]);
    }
    
    public function test_validation_succeeds_with_valid_input()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/update-identity", [
            'bvn' => '0123456789'
        ]);
        
        // Assert the response
        $response->assertStatus(200)
        ->assertJson(['success' => true]);
    }
    
    public function test_update_identity_card_fails_with_invalid_extension()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/update-identity", [
            'bvn' => '0123456789',
            'identity_card' => 'invalid.txt'
        ]);
        
        // Assert the response
        $response->assertStatus(400)
        ->assertJson(['success' => false]);
    }
    
    public function test_update_identity_card_succeeds_with_valid_card()
    {
        Storage::fake('s3');
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/update-identity", [
            'bvn' => '0123456789',
            'identity_card' => UploadedFile::fake()->image('identity_card.png')
        ]);
        
        // Assert the response
        $response->assertStatus(200)
        ->assertJson(['success' => true]);
    }
}