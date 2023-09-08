<?php
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
class TenancyAuthControllerResetpasswordTest extends TestCase
{
    public function test_reset_password_success()
    {
        $user = User::factory()->create();
        $token = Str::random(60);
        $passwordReset = \DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => \Carbon\Carbon::now(),
        ]);
        $response = $this->postJson("/tenancy/reset/password",[
            'token' => $token,
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);
        $response->assertStatus(200)
                 ->assertJson(["success" => true, "message" => "Password reset successfully" ]);
    }

    public function test_reset_password_wrong_token()
    {
        $response = $this->postJson("/tenancy/reset/password",[
            'token' => 'wrong_token',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);
        $response->assertStatus(401)
                 ->assertJson(["success" => false , "message" => "Invalid token provided" ]);
    }

    public function test_reset_password_no_token()
    {
        $response = $this->postJson("/tenancy/reset/password",[
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);
        $response->assertStatus(400)
                 ->assertJson(["success" => false, "message" => "The token field is required." ]);
    }

    public function test_reset_password_mismatch_password()
    {
        $user = User::factory()->create();
        $token = Str::random(60);
        $passwordReset = \DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => \Carbon\Carbon::now(),
        ]);
        $response = $this->postJson("/tenancy/reset/password",[
            'token' => $token,
            'password' => 'password',
            'password_confirmation' => 'password1'
        ]);
        $response->assertStatus(400)
                 ->assertJson(["success" => false, "message" => "The password confirmation does not match." ]);
    }
}