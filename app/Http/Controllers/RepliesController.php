<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{


    /**
     * RepliesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Thread $thread)
    {

        $this->validate(request(),[
            'body' => 'required',
            'user_id' => 'exists:users,id'
        ]);

        $thread->addReply([
            'body'=> request('body'),
            'user_id' => auth()->id()
            ]
        );

        return back();
    }
}
