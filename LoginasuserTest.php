<?php
use App\Models\User;
use Tests\TestCase;

class UserControllerLoginasuserTest extends TestCase
{
    /**
     * Test login as user success
     *
     * @return void
     */
    public function testLoginAsUserSuccess()
    {
        // Create a user
        $user = User::factory()->create();
        
        // Call api endpoint
        $response = $this->postJson("/login/as", [
            'user_id' => $user->id
        ]);
        
        // Assert the response
        $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'data'
        ])->assertJson([
            'success' => true
        ]);
    }

    /**
     * Test login as user failure
     *
     * @return void
     */
    public function testLoginAsUserFailure()
    {
        // Create a user
        $user = User::factory()->create();
        
        // Call api endpoint
        $response = $this->postJson("/login/as");
        
        // Assert the response
        $response->assertStatus(422)
        ->assertJsonStructure([
            'success',
            'message'
        ])->assertJson([
            'success' => false
        ]);
    }
}