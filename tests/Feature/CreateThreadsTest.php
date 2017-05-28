<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadsTest extends TestCase
{

    Use DatabaseMigrations;

    /** @test */

    function an_authenticated_user_can_create_new_thread()
    {
        // signed user

        $this->signIn();
        // create new thread and it should be redirected to that thread page
        $thread = make(Thread::class);
        $threadPath = route('threads.showwithslug', [$thread->channel->slug, 1]);
        $this->post(route('threads.store'), $thread->toArray())
            ->assertRedirect($threadPath);


        // new thread it should have id 1 and should be visible
        $response = $this->get($threadPath);

        $response->assertSee($thread->body);
    }


    /** @test */

    function to_crate_thread_title_is_required()
    {
        $response = $this->publishThread(['title' => null]);
        $response->assertSessionHasErrors('title');
    }

    /** @test */

    function to_crate_thread_body_is_required()
    {
        $response = $this->publishThread(['body' => null]);
        $response->assertSessionHasErrors('body');
    }

    /** @test */

    function to_crate_thread_valid_chanell_is_required()
    {
        $response = $this->publishThread(['channel_id' => 777777]);
        $response->assertSessionHasErrors('channel_id');
    }

    /**
     * @test
     */
    public function guest_cant_create_thread() {

        // create new thread
        $thread = make(Thread::class);

        $this->post(route('threads.store'), $thread->toArray())
            ->assertRedirect(route('login'));

        // new thread should be visible
        $this->get(route('threads.index'))
            ->assertDontSee($thread->body);
    }


    /**
     * @test
     */
    public function guest_cant_see_create_thread_page() {

        // create new thread
        $thread = make(Thread::class);

        $response = $this->post(route('threads.store'), $thread->toArray());
        $response->assertRedirect(route('login'));

    }

    /**
     * @param $attributes
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function publishThread($attributes): \Illuminate\Foundation\Testing\TestResponse
    {
// signed user
        $this->signIn();
        // create new thread and it should be redirected to that thread page
        $thread = make(Thread::class, $attributes);
        $response = $this->post(route('threads.store'), $thread->toArray());
        return $response;
    }
}
