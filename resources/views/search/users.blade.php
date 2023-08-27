<x-app-layout>
    <x-bootstrap>
        <div class="container">
            <span class="d-block my-3">
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

            <div class="mt-5">
                @if($users->count() > 0)
                @foreach($users as $user)
                <div class="row">
                    <div class="col-2">
                        <a href="{{route('users.show', $user->id)}}" class="rounded-circle">
                            <img src="{{$user->profile_photo_url}}" alt="{{$user->name}}" class="rounded-circle" style="height:50px; width:50px; object-fit:cover">
                        </a>
                    </div>
                    <div class="col-7">
                        <h5><a href="{{route('users.show', $user->id)}}">{{$user->name}}</a></h5>
                    </div>
                    <div class="col-3">
                        @if($user->id !== Auth::user()->id)
                        <a href="{{route('users.follow', $user->id)}}" class="btn btn-outline-primary">
                            @if(Auth::user()->isfollowing($user->id))
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
                <h4>No users to show</h4>
                @endif
            </div>
        </div>
    </x-bootstrap>
</x-app-layout>