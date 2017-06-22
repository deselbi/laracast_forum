<?php

namespace Tests\Feature;

use App\Reply;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class FavoritesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_authenticated_user_can_favorite_any_reply()
    {

        $reply = create(Reply::class);

        // authenticated user
        $this->signIn();

        // user post to 'favorite' endpoint
        $response = $this->post('favorites/'. $reply->id . '/reply')
            ->assertStatus(200);

        // it shouild be recorced in database
        $this->assertCount(1, $reply->favorites, $response->getContent());

    }

    /** @test */
    public function guest_can_not_favorite()
    {


        // user post to 'favorite' endpoint
        $response = $this->post('favorites/1/reply')
            ->assertRedirect(route('login'));

    }

    /** @test */
    public function user_may_favorite_something_only_once()
    {
        $reply = create(Reply::class);

        // authenticated user
        $this->signIn();

        // user post to 'favorite' endpoint
        $response = $this->post('favorites/'. $reply->id . '/reply')
            ->assertStatus(200);

        $response = $this->post('favorites/'. $reply->id . '/reply')
            ->assertStatus(200);

        // it shouild be recorced in database
        $this->assertCount(1, $reply->favorites, $response->getContent());

    }
}
