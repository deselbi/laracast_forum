<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable;

    protected $guarded = [];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function isFavorited()
    {
        if(! auth()->check() ) {
            return false;
        }

        return $this->favorites()->where('user_id', auth()->user()->id)->exists();
    }


}
