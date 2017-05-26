<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Auth\AuthenticationException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ParticipateInForum extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function an_authenticated_user_may_post_replies_to_thread()
    {
        // authenticated user
        $user = factory(User::class)->create();
        $this->be($user);

        //  thread exists
        $thread = factory(Thread::class)->create();

        // user adds reply to thread
        $reply=factory(Reply::class)->make();
        $response = $this->post('/threads/'.$thread->id.'/replies', $reply->toArray());
        $response->assertStatus(302);
        // reply should be visible on thread page
        $this->get($thread->path())
            ->assertSee($reply->body);
    }

    /** @test */
    function unauthenticated_user_may_not_post_replies_to_thread()
    {
        //  thread exists
        $thread = factory(Thread::class)->create();

        // if unauthenticated user tries to adds reply to a thread it should be redirected to the login page
        $reply=factory(Reply::class)->make();
        $response = $this->post('/threads/'.$thread->id.'/replies', $reply->toArray());

        $response->assertRedirect(route('login'));

        // reply should not be visible on thread page
        $this->get($thread->path())
            ->assertDontSee($reply->body);
    }
}
