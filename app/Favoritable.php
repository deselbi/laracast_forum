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

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function isFavorited()
    {
        if (!auth()->check()) {
            return false;
        }

        return $this->favorites->where('user_id', auth()->user()->id)->count() > 0;
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}