<x-app-layout>
    <x-bootstrap>
        @if($user !== null)
        <div class="container py-3">
            <img src="{{$user->profile_photo_url}}" alt="{{$user->name}}" class="rounded-circle" style="width:150px; height:150px; object-fit:cover;">
            <h3>{{$user->name}}</h3>
            <h4>{{$user->email}}</h4>
            <h4>{{count($user->posts)}} posts</h4>
            <h4>
                <a href="{{route('users.followers', $user->id)}}" class="text-decoration-none text-black">{{count($user->followers)}} followers</a>
            </h4>
            <h4>
                <a href="{{route('users.following', $user->id)}}" class="text-decoration-none text-black">{{count($user->following)}} following</a>
            </h4>
            @if(Auth::user()->id !== $user->id)
            <a href="{{route('users.follow', $user->id)}}" class="btn btn-outline-primary">
                @if(Auth::user()->isFollowing($user->id))
                Unfollow
                @else
                Follow
                @endif
            </a>
            @endif
            @if(Auth::user()->hasRole('admin'))
            <form action="{{route('dashboard.users.destroy', $user->id)}}" method="post" class="my-2">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" type="submit">Delete user</button>
            </form>
            @endif
            @if(count($user->posts) > 0)
            <div class="d-flex gap-2 flex-wrap">
                @foreach($user->posts as $post)
                <x-post-card :post="$post" />
                @endforeach
            </div>
            @else
            <h3>No posts yet</h3>
            @endif
        </div>
        @else
        <div>
            <h2>User not found</h2>
        </div>
        @endif
    </x-bootstrap>
</x-app-layout>