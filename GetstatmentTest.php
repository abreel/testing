<?php
use Tests\TestCase;

class ProviderControllerGetstatmentTest extends TestCase
{
    /** @test */
    public function it_should_return_error_when_no_data_is_sent_along_request()
    {
        $this->postJson('/provider/disbursement/get/statment')
            ->assertStatus(422)
            ->assertJsonValidationErrors(['data']);
    }

    /** @test */
    public function it_should_return_a_valid_response_when_data_is_sent_with_request()
    {
        $this->postJson('/provider/disbursement/get/statment', [
            'data' => 'test_data'
        ])->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    /** @test */
    public function it_should_return_an_exception_on_failure()
    {
        $this->postJson('/provider/disbursement/get/statment', [
            'data' => 'test_data'
        ])->assertStatus(500);
    }
}
