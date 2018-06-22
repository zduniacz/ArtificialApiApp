<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Post;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostReadTest extends TestCase
{
   
    protected $post;

    public function setUp()
    {
        parent::setUp();
        $post = new Post;
        $this->post = $post->create([
            'title' => 'Test Post Title',
            'body' => 'Test Post Body. Test Post Body.',
            'user_id' => 1,
            'category_id' => 1
        ]);
    }

    public function tearDown()
    {
        $this->post->delete();
    }
    
    /** @test */
    public function user_can_get_a_list_of_posts()
    {
        $response = $this->get('/api/posts');
        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_get_a_single_post()
    {
        $response = $this->get('/api/posts');
        $response->assertStatus(200);
        $this->assertContains($this->post->title, $response->content());
    }
}
