<?php
use Tests\TestCase;

class ProviderControllerGetpublicbanklistTest extends TestCase
{
    public function test_success_when_getting_all_banks_with_no_search_parameter()
    {
        // Call api endpoint
        $response = $this->getJson("/provider/disbursement/bank/list");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'status' => true
        ]);
    }

    public function test_success_when_getting_all_banks_with_search_parameter()
    {
        // Call api endpoint
        $response = $this->getJson("/provider/disbursement/bank/list?search=keyword");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'status' => true
        ]);
    }

    public function test_success_when_getting_all_banks_with_per_page_parameter()
    {
        // Call api endpoint
        $response = $this->getJson("/provider/disbursement/bank/list?perPage=10");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'status' => true
        ]);
    }

    public function test_failure_when_invalid_parameter_is_passed()
    {
        // Call api endpoint
        $response = $this->getJson("/provider/disbursement/bank/list?invalidParameter=10");

        // Assert the response
        $response->assertStatus(400);
    }

    public function test_failure_when_invalid_per_page_parameter_is_passed()
    {
        // Call api endpoint
        $response = $this->getJson("/provider/disbursement/bank/list?perPage=invalidValue");

        // Assert the response
        $response->assertStatus(400);
    }
}
