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

        $this->actingAs(factory(User::class)->create());
        // create new thread and it should be redirected to that thread page
        $thread = make(Thread::class);
        $this->post(route('threads.store'), $thread->toArray())
            ->assertRedirect(route('threads.show', [1]));


        // new thread it should have id 1 and should be visible
        $response = $this->get(route('threads.show', [1]));

        $response->assertSee($thread->body);
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
}
