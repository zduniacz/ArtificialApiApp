<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class AuthTest extends TestCase
{

    /** @test */
    public function a_registered_user_can_login()
    {
        // get a registered user
        $user = User::where('id', 1)->first();
        $user->password = 'ilovecats';

        $this->actingAs($user);

         $response = $this->json(
            'POST', 
            '/api/login',
            [
                'email' => $user->email, 
                'password' => $user->password
            ]
        );

        $response
            ->assertStatus(200)
            ->assertJson([
            'success' => true]
        );
    }
}
