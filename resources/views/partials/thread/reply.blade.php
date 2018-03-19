<div class="panel panel-default">
    <div class="panel-heading">
    <div class="level">

        <h5 class="flex">
        <a href="#">
            <a href="{{route('profiles.show', $reply->owner->name) }}">{{$reply->owner->name}}</a>
        </a>
        said {{$reply->created_at->diffForHumans()}}
        </h5>
        <div>
            <form method="post" action="/favorites/{{ $reply->id }}/reply">
                {{csrf_field()}}
                <button type="submit" class="btn btn-deault" {{$reply->isFavorited() ? 'disabled' : ''}}>
                    {{ $reply->favorites_count }} {{str_plural("Favorite", $reply->favorites_count)}}
                </button>

            </form>
        </div>
        
    </div>

    </div>

    <div class="panel-body">
        {{ $reply->body }}
    </div>

</div>