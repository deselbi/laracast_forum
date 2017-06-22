<?php

namespace Tests\Unit;

use App\Favorite;
use App\Reply;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavoriteTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_be_created()
    {
        $user_id  = create(User::class)->id;
        $reply_id = create(Reply::class)->id;

        Favorite::Create( [
            'user_id' => $user_id ,
            'favorited_id' => $reply_id,
            'favorited_type' => Reply::class
        ]);


        $this->assertEquals(1, Favorite::all()->count());

    }

    /** @test */
    public function has_factory()
    {

        $favorite = create(Favorite::class);


    }

}
