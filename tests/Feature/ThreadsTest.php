<?php

namespace Tests\Feature;

use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function a_user_can_browsw_threads()
    {
        $thread = factory(Thread::class)->create();
        $response = $this->get('/threads');

        $response->assertStatus(200);

        $response->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /**
     * @test
     */
    public function a_user_can_browse_a_thread_by_id(){

        $thread = factory(Thread::class)->create();
        $response = $this->get('/threads/'.$thread->id);
        $response->assertStatus(200);
        $response->assertSee($thread->title);

    }
}
