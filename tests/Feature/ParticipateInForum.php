<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInForum extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function an_authenticated_user_may_post_replies_to_thread()
    {
        // authenticated user
        $this->signIn();

        //  thread exists
        $thread = create(Thread::class);

        // user adds reply to thread
        $reply=make(Reply::class);
        $response = $this->post('/threads/'.$thread->id.'/replies', $reply->toArray());
        $response->assertStatus(302);
        // reply should be visible on thread page
        $this->get($thread->path())
            ->assertSee($reply->body);
    }


    /** @test */
    function body_is_required_to_create_reply()
    {
        $response = $this->publishReply(['body' => null]);

        $response->assertSessionHasErrors('body');
    }


    /** @test */
    function valid_user_id_is_required_to_create_reply()
    {
        $response = $this->publishReply(['user_id' => null]);
        $response->assertSessionHasErrors('user_id');

        $response = $this->publishReply(['user_id' => 999999]);
        $response->assertSessionHasErrors('user_id');
    }

    /** @test */
    function unauthenticated_user_may_not_post_replies_to_thread()
    {
        //  thread exists
        $thread = create(Thread::class);

        // if unauthenticated user tries to adds reply to a thread it should be redirected to the login page
        $reply = make(Reply::class);
        $response = $this->post('/threads/'.$thread->id.'/replies', $reply->toArray());

        $response->assertRedirect(route('login'));

        // reply should not be visible on thread page
        $this->get($thread->path())
            ->assertDontSee($reply->body);
    }

    /**
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function publishReply($attributes = []): \Illuminate\Foundation\Testing\TestResponse
    {
// authenticated user
        $this->signIn();
        //  thread exists
        $thread = create(Thread::class);

        // user adds reply to thread
        $reply = make(Reply::class, $attributes);
        $response = $this->post('/threads/' . $thread->id . '/replies', $reply->toArray());
        return $response;
    }
}
