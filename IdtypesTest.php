<?php
use Tests\TestCase;

class UserComplianceControllerIdtypesTest extends TestCase
{
    public function test_idTypes_success()
    {
        // Set headers
        $headers = [
            'Accept' => 'application/json'
        ];

        // Call api endpoint
        $response = $this->getJson('/id-types', $headers);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data'
        ]);
        $response->assertJson([
            'success' => true,
            'message' => 'Options Fetched Successfully',
            'data' => [
                'NIN',
                'VOTERS CARD',
                'DRIVERS LICENSE',
                'PASSPORT',
                'NATIONAL ID CARD'
            ]
        ]);
    }

    public function test_idTypes_without_accept_header()
    {
        // Call api endpoint
        $response = $this->getJson('/id-types');

        // Assert the response
        $response->assertStatus(406);
        $response->assertJsonStructure([
            'success',
            'message'
        ]);
        $response->assertJson([
            'success' => false,
            'message' => 'Accept header must be set to application/json'
        ]);
    }

    public function test_idTypes_with_invalid_accept_header()
    {
        // Set headers
        $headers = [
            'Accept' => 'text/plain'
        ];

        // Call api endpoint
        $response = $this->getJson('/id-types', $headers);

        // Assert the response
        $response->assertStatus(406);
        $response->assertJsonStructure([
            'success',
            'message'
        ]);
        $response->assertJson([
            'success' => false,
            'message' => 'Accept header must be set to application/json'
        ]);
    }
}
