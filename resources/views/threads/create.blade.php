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
                                 <label for="title"> Title: </label>
                                 <input type="text" name="title" id="title" placeholder="Title" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="title"> Body: </label>
                                <textarea name="body" id="body" placeholder="Body" class="form-control" rows="8"> </textarea>
                            </div>

                            <button type="submit"> Publish</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
