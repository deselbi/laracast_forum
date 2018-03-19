<?php

namespace Tests\Feature;

use App\Reply;
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

    /** @test */

    function user_can_delete_own_thread()
    {
        // signed user
        $user = create(User::class);

        $thread = create(Thread::class, ['user_id' => $user->id]);

        $reply = create(Reply::class, ['thread_id' => $thread->id]);

        $this->assertDatabaseHas('threads', $thread->toArray());

        $this->signIn($user);

        $this->delete(route('threads.destroy', $thread->id))
            ->assertStatus(302);

        $this->assertDatabaseMissing('threads', $thread->toArray());

        $this->assertDatabaseMissing('replies',$reply->toArray());

    }


    /** @test */

    function guest_cant_delete_other_user_thread()
    {
        $owner = create(User::class);

        $thread = create(Thread::class, ['user_id' => $owner->id]);

        $this->delete(route('threads.destroy', $thread->id))
            ->assertRedirect(route('login'));

        $this->assertDatabaseHas('threads', $thread->toArray());
    }



    /** @test */

    function user_cant_delete_other_user_thread()
    {
        $this->markTestIncomplete("TODO: implementend in next Episode.");
        return;

        $owner = create(User::class);

        $thread = create(Thread::class, ['user_id' => $owner->id]);

        $user = create(User::class);

        $this->signIn($user);

        $this->delete(route('threads.destroy', $thread->id))
            ->assertStatus(403);

        $this->assertDatabaseHas('threads', $thread->toArray());
    }


    /**
     * @param $attributes
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function publishThread($attributes): \Illuminate\Foundation\Testing\TestResponse
    {
        // signed user
        $this->signIn();
        // create new thread and it should be redirected to that thread page
        $thread = make(Thread::class, $attributes);

        $response = $this->post(route('threads.store'), $thread->toArray());

        return $response;
    }
}
