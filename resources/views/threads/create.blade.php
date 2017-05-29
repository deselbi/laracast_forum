@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Create Threads</div>

                    <div class="panel-body">
                        <form action="{{route('threads.store')}}" method="POST">
                            {{csrf_field()}}

                            <div class="form-group">
                                <label for="channel_id"> Channel: </label>
                                <select name="channel_id" id="channel_id" class="form-controll" required>
                                    <option value="">Chose Channel</option>
                                    @foreach($channels as $channel)
                                        <option value="{{$channel->id}}" {{old('channel_id') == $channel->id ? 'selected': ''}}>{{$channel->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                 <label for="title"> Title: </label>
                                 <input type="text" name="title" id="title" placeholder="Title" class="form-control" value="{{old('title')}}" required>

                            </div>

                            <div class="form-group">
                                <label for="title"> Body: </label>
                                <textarea name="body" id="body" placeholder="Body" class="form-control" rows="8" required>{{old('body')}}</textarea>
                            </div>

                            <div class="form-group">
                                <button type="submit"> Publish</button>
                            </div>
                        </form>
                        @if(count($errors))
                            <ul class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                         @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
