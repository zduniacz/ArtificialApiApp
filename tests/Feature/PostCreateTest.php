<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Post;

class PostCreateTest extends TestCase
{
    protected $user;

    /** @test */ 
    public function unauthorised_user_cannot_create_post()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $test_post_title = 'test_post_title';
        $response = $this->json('POST', '/api/posts', ['title' => $test_post_title, 'body' => 'testbody', 'category' => 1]);
        $response->assertJson([
            'data' => ['error' => 'token_not_provided']
        ]);
    }
    /** @test */ 
    public function authorised_user_can_create_post()
    {
        // login as admin user and get his JWT token to be later passed in with headers to the tested api resource
        $user = User::where('id', 1)->first();
        $token = $this->login($user);
        $this->actingAs($user);

        $test_post_title = 'test_post_title'; // stored in variable to compare if it can be found in the response
        $response = $this->json(
            'POST', 
            '/api/posts', 
            [
                'title' => $test_post_title, 
                'body' => 'testbody', 
                'category' => 1
            ], 
            [
                'Authorization' => "Bearer $token"
            ]
        );
        
        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'title' => $test_post_title
                ]
        ]);
    }

    /** @test */ 
    public function authorised_user_can_update_post()
    {

        // login as admin user and get his JWT token to be later passed in with headers to the tested api resource
        // TODO: consider moving this part to setUp() methods for DRY
        $user = User::where('id', 1)->first();
        $token = $this->login($user);
        $this->actingAs($user);

        //get a post that belongs to this user
        $post = Post::inRandomOrder()->where('user_id', $user->id)->first();

        $test_post_title = 'This title has been updated for testing'; // stored in variable to compare if it can be found in the response
        $response = $this->json('PATCH', '/api/posts/'.$post->id, ['title' => $test_post_title], ['Authorization' => "Bearer $token"]);
        $response->assertJson([
            'data' => ['title' => $test_post_title]
        ]);
    }

    /* TODO: tests with similar logic to the above, respectively for:
        authorised_user_can_dele_post 
        unauthorised_user_cannot_dele_post 
        unauthorised_user_cannot_update_post
    */

    /** @test */ 
    public function created_post_must_contain_body()
    {

        // login as admin user and get his JWT token to be later passed in with headers to the tested api resource
        // TODO: consider moving this part to setUp() methods for DRY
        $user = User::where('id', 1)->first();
        $token = $this->login($user);
        $this->actingAs($user);

        $test_post_title = 'A new post'; // stored in variable to compare if it can be found in the response
        $response = $this->json(
            'POST', 
            '/api/posts', 
            [
                'title' => $test_post_title,
                'category_id' => 1
            ], 
            [
                'Authorization' => "Bearer $token"
            ]);
        $response->assertJson([
            'body' => ['The body field is required.']
        ]);
    }
     /* TODO: more tests with similar logic to the above, where json shows expected errors for validation
        (e.g created_post_must_belong_to_a_category)
    */
}
