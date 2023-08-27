<x-app-layout>
    <x-bootstrap>
        <div class="container">

            <h3 class="my-4">{{$user->name}} - Following</h3>

            <div>
                @if($user->following->count() > 0)
                @foreach($user->following as $following)
                <div class="row">
                    <div class="col-2">
                        <a href="{{route('users.show', $following->id)}}" class="rounded-circle">
                            <img src="{{$following->profile_photo_url}}" alt="{{$following->name}}" class="rounded-circle" style="height:50px; width:50px; object-fit:cover">
                        </a>
                    </div>
                    <div class="col-7">
                        <h5><a href="{{route('users.show', $following->id)}}">{{$following->name}}</a></h5>
                    </div>
                    <div class="col-3">
                        @if($following->id !== Auth::user()->id)
                        <a href="{{route('users.follow', $following->id)}}" class="btn btn-outline-primary">
                            @if(Auth::user()->isFollowing($following->id))
                            Unfollow
                            @else
                            Follow
                            @endif
                        </a>
                        @endif
                    </div>
                </div>
                @endforeach
                @else
                <h4 class="text-center">{{$user->name}} is not following anyone</h4>
                @endif
            </div>
        </div>
    </x-bootstrap>
</x-app-layout>