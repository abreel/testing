<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use App\Models\DocumentUpload;
use Tests\TestCase;

class DocumentUploadControllerUpload_tier_documentTest extends TestCase{
    use RefreshDatabase;
    public function test_upload_tier_document_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Generate fake data
        $electricity_bill = UploadedFile::fake()->image('electricity_bill.jpg');
        $nin_file = UploadedFile::fake()->image('nin_file.jpg');
        $passport_file = UploadedFile::fake()->image('passport_file.jpg');
        $drivers_license_file = UploadedFile::fake()->image('drivers_license_file.jpg');
        $address = '1234 Fake Street';

        // Call api endpoint
        $response = $this->postJson('/core/tier-upgradeupload', [
            'address' => $address,
            'electricity_bill' => $electricity_bill,
            'nin_file' => $nin_file,
            'passport_file' => $passport_file,
            'drivers_license_file' => $drivers_license_file
        ]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Document uploaded successfully.'
        ]);
    }

    public function test_upload_tier_document_fail_when_no_document_uploaded()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Generate fake data
        $electricity_bill = UploadedFile::fake()->image('electricity_bill.jpg');
        $address = '1234 Fake Street';

        // Call api endpoint
        $response = $this->postJson('/core/tier-upgradeupload', [
            'address' => $address,
            'electricity_bill' => $electricity_bill
        ]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'Please upload either the NIN, Passport, or Driver\'s License.'
        ]);
    }

    public function test_upload_tier_document_fail_when_document_already_uploaded()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Generate fake data
        $documentUpload = DocumentUpload::factory()->create([
            'user_id' => $user->id
        ]);
        $electricity_bill = UploadedFile::fake()->image('electricity_bill.jpg');
        $nin_file = UploadedFile::fake()->image('nin_file.jpg');
        $passport_file = UploadedFile::fake()->image('passport_file.jpg');
        $drivers_license_file = UploadedFile::fake()->image('drivers_license_file.jpg');
        $address = '1234 Fake Street';

        // Call api endpoint
        $response = $this->postJson('/core/tier-upgradeupload', [
            'address' => $address,
            'electricity_bill' => $electricity_bill,
            'nin_file' => $nin_file,
            'passport_file' => $passport_file,
            'drivers_license_file' => $drivers_license_file
        ]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'Document already uploaded'
        ]);
    }
}
