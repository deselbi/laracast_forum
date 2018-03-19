<?php


namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Thread;


class UserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_has_many_threads()
    {
        $user = create(User::class);
        $thread = create(Thread::class, ['user_id'=>$user->id]);
        $this->assertContains($thread->title, $user->threads->toJson());
        $this->assertContains($thread->body, $user->threads->toJson());
    }
}
