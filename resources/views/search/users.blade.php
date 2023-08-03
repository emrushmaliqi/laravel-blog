<x-app-layout>
    <x-bootstrap>
        <div class="container">
            <span>
                Users search results for "{{$search}}"
            </span>

            <div class="d-flex gap-2">
                <form action="{{route('search.posts')}}" method="get">
                    <button name="search" value="{{$search}}" class="btn btn-outline-primary @if(request()->routeIs('search.posts')) active @endif">Posts</button>
                </form>
                <form action="{{route('search.users')}}" method="get">
                    <button name="search" value="{{$search}}" class="btn btn-outline-primary @if(request()->routeIs('search.users')) active @endif">Users</button>
                </form>
            </div>

            <div>
                @if($users->count() > 0)
                @foreach($users as $user)
                <div class="row">
                    <div class="col-4">
                        <a href="{{route('users.show', $user->id)}}">
                            <img src="{{$user->profile_photo_url}}" alt="{{$user->name}}" class="rounded-circle" style="height: 80px!important; width: 80px!important; object-fit:cover;">
                        </a>
                    </div>
                    <h4 class="col-3"><a class="text-dark text-decoration-none" href="{{route('users.show', $user->id)}}">{{$user->name}}</a></h4>
                    <h5 class="col-3">{{$user->email}}</h5>
                    @if(Auth::user()->id != $user->id)
                    <a href="{{route('users.follow', $user->id)}}" class="btn btn-primary col-2">
                        @if(Auth::user()->isFollowing($user->id))
                        Unfollow
                        @else
                        Follow
                        @endif
                    </a>
                    @endif
                </div>
                @endforeach
                @else
                <h4>No users to show</h4>
                @endif
            </div>
        </div>
    </x-bootstrap>
</x-app-layout>