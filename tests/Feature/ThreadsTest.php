<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadsTest extends TestCase
{
    public $thread;
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        $this->thread = create(Thread::class);
    }


    /**
     * @test
     */
    public function a_user_can_browsw_threads()
    {

        $response = $this->get('/threads');

        $response->assertStatus(200);

        $response->assertSee($this->thread->title)
            ->assertSee($this->thread->body);
    }

    /**
     * @test
     */
    public function a_user_can_browse_a_thread_by_id(){


        $response = $this->get('/threads/'.$this->thread->id);
        $response->assertStatus(200)
            ->assertSee($this->thread->title);

    }

    /** @test */
    public function a_user_can_read_repies_to_threads()
    {
        $reply = factory(Reply::class)->create(['thread_id'=> $this->thread->id]);

        $response = $this->get('/threads/'.$this->thread->id);
        $response->assertStatus(200)
            ->assertSee($reply->body);
    }
}
