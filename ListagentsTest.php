<?php
use App\Models\User;
use Tests\TestCase;
class AgentControllerListagentsTest extends TestCase{

    //Test success case
    public function test_list_agent_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
            
        // Call api endpoint
        $response = $this->getJson("/core/agents/{$user->id}");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'data' => [
                '*' => [
                    'users' => [
                        '*' => [
                            'id',
                            'first_name',
                            'last_name',
                            'phone',
                            'email',
                        ]
                    ],
                    'accounts' => [
                        '*' => [
                            'user' => [
                                'id',
                                'first_name',
                                'last_name',
                                'phone',
                                'email',
                                'usertype',
                            ],
                            'wallet' => [
                                'id',
                                'name',
                                'virtual_account_id',
                                'virtualAccount' => [
                                    'id',
                                    'account_name',
                                    'account_number',
                                ]
                            ],
                            'aggregator' => [
                                'id',
                                'name',
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }

    //Test failure case
    public function test_list_agent_failure(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
            
        // Call api endpoint
        $response = $this->getJson("/core/agents/{$user->id}");

        // Assert the response
        $response->assertStatus(400);
        $response->assertJsonStructure([
            'status',
            'message'
        ]);
    }

    //Test validation failure case
    public function test_list_agent_validation_failure(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
            
        // Call api endpoint
        $response = $this->postJson("/core/agents/{$user->id}");

        // Assert the response
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'status',
            'message',
            'errors' => [
                '*' => []
            ]
        ]);
    }
}