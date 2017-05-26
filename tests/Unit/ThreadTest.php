<?php

namespace Tests\Unit;

use App\Thread;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ThreadTest extends TestCase
{

    /** @var Thread */
    private  $therad;
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();

        $this->therad = factory(Thread::class)->create();
    }


    /** @test */
    public function has_replies()
    {

        $this->assertInstanceOf(Collection::class, $this->therad->replies);

    }

    /** @test */
    public function has_creator()
    {

        $this->assertInstanceOf(User::class,$this->therad->creator);

    }

    /** @test */
    public function can_add_reply()
    {
        $this->therad->addReply(
            [
                'body' => 'body',
                'user_id' => 1
            ]
        );
    }
}
