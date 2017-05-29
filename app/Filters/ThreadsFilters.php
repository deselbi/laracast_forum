<?php

namespace App\Filters;


use App\User;
use Illuminate\Http\Request;

class ThreadsFilters extends Filters
{

    protected $filters = ['by'];
    /**
     *
     * @param $username
     * @internal param $builder
     */
    protected function by($username): void
    {
        $user = User::whereName($username)->firstOrFail();

        $this->builder->where('user_id', $user->id);
    }
}