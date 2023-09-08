<?php
use App\Models\User;
use Tests\TestCase;

class ComplianceControllerUpdateotherdataTest extends TestCase
{
    /**
     * Test for successful update of other merchant data
     *
     * @return void
     */
    public function testSuccessfulUpdateOtherData()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/update-otherdata", [
            'vsystem' => 'required',
            'commercial_id' => 'required',
            'provider_credential_id' => 'required',
        ]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Data updated successfully'
        ]);
    }

    /**
     * Test for unsuccessful update of other merchant data when no merchant is found
     *
     * @return void
     */
    public function testUnsuccessfulUpdateOtherDataWhenMerchantNotFound()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/update-otherdata", [
            'vsystem' => 'required',
            'commercial_id' => 'required',
            'provider_credential_id' => 'required',
        ]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'Cant find merchant'
        ]);
    }

    /**
     * Test for unsuccessful update of other merchant data when bad data is sent
     *
     * @return void
     */
    public function testUnsuccessfulUpdateOtherDataWhenBadDataSent()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/update-otherdata", [
            'vsystem' => '',
            'commercial_id' => '',
            'provider_credential_id' => '',
        ]);

        // Assert the response
        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'vsystem',
            'commercial_id',
            'provider_credential_id'
        ]);
    }
}
