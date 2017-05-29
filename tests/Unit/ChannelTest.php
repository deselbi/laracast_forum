<?php

namespace Tests\Feature;

use App\Channel;
use App\Thread;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class ChannelTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_has_threads()
    {
        $channel = create(Channel::class);

        $this->assertInstanceOf(Collection::class, $channel->threads);

    }

    /** @test */
    public function it_returns_asssociated_threads()
    {
        $channel = create(Channel::class);
        $thread = create(Thread::class, ['channel_id'=> $channel->id]);
        $thread2 = create(Thread::class, ['channel_id'=> $channel->id]);
        $this->assertTrue($channel->threads->contains($thread));
        $this->assertTrue($channel->threads->contains($thread2));
    }
}
