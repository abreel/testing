<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\BvnVerification;
use Tests\TestCase;

class ComplianceControllerVerifybvnTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test verify bvn with valid data
     *
     * @return void
     */
    public function testVerifyBvnValidData()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Data for BVN validation
        $data = [
            'name' => 'John Doe',
            'bvn' => '1234',
            'phone' => '080xxxxxxxx',
            'dob' => '10-Jul-1990'
        ];

        // Call api endpoint
        $response = $this->postJson('/core/compliance/verify-bvn', $data);

        // Assert the response
        $response->assertStatus(201);
        $response->assertJson(['success' => true]);
    }

    /**
     * Test verify bvn with empty data
     *
     * @return void
     */
    public function testVerifyBvnEmptyData()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Data for BVN validation
        $data = [
            'name' => '',
            'bvn' => '',
            'phone' => '',
            'dob' => ''
        ];

        // Call api endpoint
        $response = $this->postJson('/core/compliance/verify-bvn', $data);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson(['success' => false]);
    }

    /**
     * Test verify bvn with wrong data
     *
     * @return void
     */
    public function testVerifyBvnWrongData()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Data for BVN validation
        $data = [
            'name' => 'John Doe',
            'bvn' => '1234',
            'phone' => '080xxxxxxxx',
            'dob' => '10-Jul-1990'
        ];

        // Call api endpoint
        $response = $this->postJson('/core/compliance/verify-bvn', $data);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson(['success' => false]);
    }

    /**
     * Test verify bvn with duplicate bvn
     *
     * @return void
     */
    public function testVerifyBvnDuplicateBvn()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Data for BVN validation
        $data = [
            'name' => 'John Doe',
            'bvn' => '1234',
            'phone' => '080xxxxxxxx',
            'dob' => '10-Jul-1990'
        ];

        // Create existing BVN
        $bvnVerification = BvnVerification::factory()->create();

        // Call api endpoint
        $response = $this->postJson('/core/compliance/verify-bvn', $data);

        // Assert the response
        $response->assertStatus(422);
        $response->assertJson(['success' => false]);
    }
}
