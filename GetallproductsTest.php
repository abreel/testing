<?php
use App\Models\User;
use Tests\TestCase;
class BillsControllerGetallproductsTest extends TestCase
{
    public function test_get_all_products_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->getJson("/bills/products");

        // Assert success status
        $response->assertStatus(200);

        // Assert response format
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'current_page',
                'data' => [
                    [
                        'id',
                        'name',
                        'biller' => [
                            'id',
                            'name',
                            'category' => [
                                'id',
                                'name',
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function test_get_all_products_with_query_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/bills/products?product=Test");

        // Assert success status
        $response->assertStatus(200);

        // Assert response format
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'current_page',
                'data' => [
                    [
                        'id',
                        'name',
                        'biller' => [
                            'id',
                            'name',
                            'category' => [
                                'id',
                                'name',
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function test_get_all_products_with_biller_query_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/bills/products?biller=TestBiller");

        // Assert success status
        $response->assertStatus(200);

        // Assert response format
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'current_page',
                'data' => [
                    [
                        'id',
                        'name',
                        'biller' => [
                            'id',
                            'name',
                            'category' => [
                                'id',
                                'name',
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function test_get_all_products_with_category_query_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/bills/products?category=TestCategory");

        // Assert success status
        $response->assertStatus(200);

        // Assert response format
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'current_page',
                'data' => [
                    [
                        'id',
                        'name',
                        'biller' => [
                            'id',
                            'name',
                            'category' => [
                                'id',
                                'name',
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function test_get_all_products_without_authentication_failure()
    {
        // Call api endpoint
        $response = $this->getJson("/bills/products");

        // Assert Unauthorized status
        $response->assertStatus(401);

        // Assert response format
        $response->assertJsonStructure([
            'message',
        ]);
    }
}