@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
        <div class="page-header">
            <h1> {{ $user->name }}</h1>
            <small>Since  {{$user->created_at->diffForHumans()}}</small>
            <small> {{ $user->email }} </small>
        </div>

            @foreach($threads as $thread)


                    <div class="panel panel-default">
                        <div class="panel-heading">

                            <aside>
                                posted: {{ $thread->created_at->diffForHumans() }}
                            </aside>
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




            @endforeach
        {{ $threads->links()}}
            </div>
        </div>
    </div>
@endsection