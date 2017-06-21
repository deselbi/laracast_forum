<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Filters\ThreadsFilters;
use App\Thread;
use Illuminate\Http\Request;

class ThreadsController extends Controller
{
    /**
     * ThreadsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show', 'showwithslug']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel, ThreadsFilters $filter)
    {
        $threads = $this->getThreads($channel, $filter);

        if(request()->wantsJson()){
            return $threads;
        }

        return view('threads.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'=>'required',
            'body' => 'required',
            'channel_id' => 'required|exists:channels,id'
        ]);

        $thread = Thread::create(
            [
                'user_id' => auth()->id(),
                'channel_id' => request('channel_id'),
                'title' => request('title'),
                'body' => request('body')
            ]
        );

        return redirect($thread->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show(Thread $thread)
    {
        return $this->showThreadWithReplies($thread);
    }


    /**
     * show allias for route with slug
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function showwithslug($channel, Thread $thread)
    {
        return $this->showThreadWithReplies($thread);

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {
        //
    }

    /**
     * @param Channel $channel
     * @param ThreadsFilters $filter
     * @return mixed
     */
    public function getThreads(Channel $channel, ThreadsFilters $filter)
    {
        $builder = Thread::latest();

        if ($channel->exists) {
            $builder->where('channel_id', $channel->id);
        }

        $threads = $builder->filter($filter)->get();
        return $threads;
    }

    /**
     * @param Thread $thread
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function showThreadWithReplies(Thread $thread)
    {
        $replies = $thread->replies()->paginate(20);
        return view('threads.show', compact('thread', 'replies'));
    }
}
