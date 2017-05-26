@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a>{{$thread->creator->name}}</a> posted {{$thread->title}}
                    </div>

                    <div class="panel-body">
                        <article>
                            <h4>{{$thread->title}}</h4>
                            <div class="body">
                                {{$thread->body}}
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
               @if(auth()->check())
                    <form method="post" action="{{ route('threads.replies',[$thread->id]) }}" >
                        {{ csrf_field() }}
                        <div class="form-group">
                            <textarea name="body" id="body" class="form-control" placeholder="Say something..."> </textarea>
                        </div>
                        <button type="submit"> Post</button>
                    </form>
                @else
                    <p> please <a href="{{route('login')}}"> sign in</a> to participate</p>
                @endif
            </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">

            <div class="col-md-8 col-md-offset-2">

                @foreach($thread->replies as $reply)
                    @include('partials.thread.reply')
                @endforeach
            </div>
        </div>
    </div>

@endsection

