<?php

namespace Tests\Feature;

use App\Channel;
use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Routing\Route;
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
    public function a_user_can_browse_threads()
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
    public function a_user_can_read_replies_to_threads()
    {
        $reply = factory(Reply::class)->create(['thread_id'=> $this->thread->id]);

        $response = $this->get('/threads/'.$this->thread->id);
        $response->assertStatus(200)
            ->assertSee($reply->body);
    }


    /** @test */
    public function a_user_can_filter_threads_by_channel_slug()
    {

        $channel = create(Channel::class);
        $threadInChannel = create(Thread::class, ['channel_id'=>$channel->id]);

        $this->get("/chanells/{$channel->slug}")
                ->assertSee($threadInChannel->title)
                ->assertDontSee($this->thread->title);

    }

    /** @test */
    public function a_user_can_filter_threads_by_any_username()
    {
        $johnDoe = create(User::class, ['name' => 'JohnDoe']);
        $this->signIn($johnDoe);

        $jonDoesThread = create(Thread::class, ['user_id' => $johnDoe->id]);
        $notJonDoesThread = create(Thread::class);
        $this->get('threads?by=JohnDoe')
            ->assertSee($jonDoesThread->title)
            ->assertDontSee($notJonDoesThread->title);


    }

    /** @test */
    public function a_user_can_filter_threads_by_popularity()
    {

        $treadWithTwoReplies = create(Thread::class);

        create(Reply::class, ['thread_id'=> $treadWithTwoReplies->id], 2);


        $treadWithThreeReplies = create(Thread::class);

        create(Reply::class, ['thread_id'=> $treadWithThreeReplies->id], 3);





        $response = $this->getJson('threads?popular=1')->json();

        $this->assertEquals([3,2,0], array_column($response, 'replies_count'));
    }
}
