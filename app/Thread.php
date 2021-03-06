<?php

namespace App;

use App\Filters\ThreadsFilters;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use Favoritable;
    protected $guarded =[];

    protected $with=['channel'];
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function ($builder) {
           $builder->withCount('replies');
        });

        static::addGlobalScope('creator', function ($builder) {
            $builder->with('creator');
        });

        static::deleting(function ($thread) {
            $thread->replies()->delete();
        });
    }


    /**
     * @return string
     */
    public function path()
    {
        return '/threads/'.$this->channel->slug.'/'.$this->id;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * @param $reply
     */
    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }

    /**
     * @param $query
     * @param ThreadsFilters $filters
     * @return mixed
     */
    public function scopeFilter($query, ThreadsFilters $filters)
    {
        return $filters->apply($query);
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }
}
