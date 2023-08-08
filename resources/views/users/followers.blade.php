<x-app-layout>
    <x-bootstrap>
        <div class="container">

            <h3>{{$user->name}} - Followers</h3>

            <div>
                @if($user->followers->count() > 0)
                @foreach($user->followers as $follower)
                <div class="row">
                    <div class="col-2">
                        <a href="{{route('users.show', $follower->id)}}" class="rounded-circle">
                            <img src="{{$follower->profile_photo_url}}" alt="{{$follower->name}}" class="rounded-circle" style="height:50px; width:50px; object-fit:cover">
                        </a>
                    </div>
                    <div class="col-7">
                        <h5><a href="{{route('users.show', $follower->id)}}">{{$follower->name}}</a></h5>
                    </div>
                    <div class="col-3">
                        @if(Auth::user()->id == $user->id)
                        <a href="{{route('users.remove-following', $follower->id)}}" class="btn btn-outline-primary" onclick="return confirm('Are you sure?')">Remove</a>
                        @elseif(Auth::user()->id != $follower->id)
                        <a href="{{route('users.follow', $follower->id)}}" class="btn btn-outline-primary">
                            @if(Auth::user()->isFollowing($follower->id))
                            Unfollow
                            @else
                            Follow
                            @endif
                        </a>
                        @endif

                    </div>
                    @endforeach
                    @else
                    <h4 class="text-center">{{$user->name}} is not followed by anyone</h4>
                    @endif
                </div>
            </div>
            @if(Session::has('success'))
            <x-alert type="success">{{Session::get('success')}}</x-alert>
            @endif
    </x-bootstrap>
</x-app-layout>