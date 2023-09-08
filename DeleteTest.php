:

<?php
                use Tests\TestCase;
                class TenancyControllerDeleteTest extends TestCase{
                    public function deleteTest(){
                        // Create a user and authenticate
                        $user = User::factory()->create();
                        $this->actingAs($user);
                        
                        // Call api endpoint
                        $response = $this->deleteJson("/delete-tenant/{$user->id}");
                
                        // Assert the response
                        $response->assertStatus(200);
                        $response->assertJson([
                            'status' => true,
                            'message' => 'Tenant has been deleted.'
                        ]);
                    }
                }