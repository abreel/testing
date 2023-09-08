<?php
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ComplianceControllerUpdatebusinessdocsTest extends TestCase
{
    public function test_success_update_business_docs(){
        $user = User::factory()->create();
        $this->actingAs($user);
        $data = [
            'id_card_no' => '1234567890',
            'id_card_type' => 'driving_license',
            'id_card_exp_date' => '2021-10-09',
            'identity_card' => UploadedFile::fake()->image('front.jpg', 500, 500),
            'selfie_with_card' => UploadedFile::fake()->image('back.jpg', 500, 500)
        ];
        $response = $this->postJson('/update-business-docs/'.$user->id, $data);
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Business document updated successfully'
        ]);
    }

    public function test_failure_update_business_docs_without_id_card_type(){
        $user = User::factory()->create();
        $this->actingAs($user);
        $data = [
            'id_card_no' => '1234567890',
            'id_card_exp_date' => '2021-10-09',
            'identity_card' => UploadedFile::fake()->image('front.jpg', 500, 500),
            'selfie_with_card' => UploadedFile::fake()->image('back.jpg', 500, 500)
        ];
        $response = $this->postJson('/update-business-docs/'.$user->id, $data);
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'Id card type is required'
        ]);
    }

    public function test_failure_update_business_docs_with_bad_validation(){
        $user = User::factory()->create();
        $this->actingAs($user);
        $data = [
            'id_card_no' => '1234567890',
            'id_card_type' => 'driving_license',
            'id_card_exp_date' => '2021-10-09',
            'identity_card' => 'not_an_image',
            'selfie_with_card' => UploadedFile::fake()->image('back.jpg', 500, 500)
        ];
        $response = $this->postJson('/update-business-docs/'.$user->id, $data);
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'The identity card must be an image.'
        ]);
    }
}
