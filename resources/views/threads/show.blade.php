@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{$thread->title}}</div>

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

    <div class="row">
        <div class="container">
            <div class="col-md-8 col-md-offset-2">

                @foreach($thread->replies as $reply)
                <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="#">{{$reply->owner->name}}</a> said
                    {{$reply->created_at->diffForHumans()}}
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        {{ $reply->body }}
                    </div>
                </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
