<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 22.2.18.
 * Time: 18.10
 */

namespace app;

use App\Favorite;

trait Favoritable
{
    public function favorite()
    {
        $data = [
            'user_id' => auth()->id(),
            'favorited_id' => $this->id,
            'favorited_type' => self::class
        ];

        if( Favorite::where($data)->exists() ) {
            return;
        }

        $this->favorites()->create(['user_id' => auth()->id()]);
    }
}