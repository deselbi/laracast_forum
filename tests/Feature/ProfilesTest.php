<?php


namespace Tests\Feature;

use App\Thread;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class ProfilesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_has_a_profile()
    {

        $user = create(User::class);
        $this->get("/profiles/{$user->name}")
         ->assertSee($user->name)
         ->assertSee($user->email);

    }


    /** @test */
    public function profile_display_all_users_threads()
    {
        $user = create(User::class);
        $thread = create(Thread::class, ['user_id'=>$user->id]);
        $this->get("/profiles/{$user->name}")
            ->assertSee($user->name)
            ->assertSee($thread->title);


    }
}
