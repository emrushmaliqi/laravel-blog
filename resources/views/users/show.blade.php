<x-app-layout>
    <x-bootstrap>
        @if($user !== null)
        <div class="container py-3 d-flex">

            <div class="w-75 d-flex gap-2 flex-wrap">
                @if(count($user->posts) > 0)
                <h1 class="my-5">{{$user->name}}</h1>

                <div class="w-100">
                    <div class="w-75 d-flex border-bottom">
                        <span class="border-bottom border-primary lh-lg">
                            Posts
                        </span>
                    </div>
                </div>
                @foreach($user->posts as $post)
                <div class="w-100">
                    <div class="border-bottom w-75 d-flex" style="padding:30px 0 50px 0;">
                        <div class="w-75 d-flex flex-column">
                            <span>Published {{$post->created_at->diffForHumans()}}</span>
                            <a href="{{route('posts.show', $post->id)}}" class="text-decoration-none text-black">
                                <h4>{{$post->title}}</h4>
                                <p>
                                    {{Str::limit($post->body, 200)}}
                                </p>
                            </a>
                            <div class="d-flex justify-content-between">
                                <a href="{{route('posts.category', $post->category->slug)}}" class="text-decoration-none text-black py-1 px-2" style="background-color: #ddd; border-radius: 20px"><small>{{$post->category->name}}</small></a>
                                @if($post->isSaved())

                                <a href="{{route('posts.save', $post->id)}}" id="save-btn" class="text-decoration-none text-dark fs-5">
                                    <i class="bi bi-bookmark-x-fill"></i>
                                </a>

                                @else

                                <a href="{{route('posts.save', $post->id)}}" id="save-btn" class="text-decoration-none text-dark fs-5">
                                    <i class="bi bi-bookmark-plus"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                        <div class="w-25 d-flex align-items-center justify-content-end">
                            @if($post->images->count())
                            <img src="{{$post->images[0]->url()}}" alt="{{$post->title}}" style="width:120px; height:120px; object-fit:cover">
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <h3 class="align-self-center mx-auto">No posts yet</h3>
                @endif
            </div>
            <div class="w-25 mt-5">
                <img src="{{$user->profile_photo_url}}" alt="{{$user->name}}" class="rounded-circle" style="width:100px; height:100px; object-fit:cover;">
                <h6 class="pt-3" style="font-size: 16px;">{{$user->name}}</h6>
                <a href="{{route('users.followers', $user->id)}}" class="text-decoration-none text-secondary d-block">{{count($user->followers)}} followers</a>
                <a href="{{route('users.following', $user->id)}}" class="text-decoration-none text-secondary d-block mb-4">{{count($user->following)}} following</a>
                @if(Auth::user()->id !== $user->id)
                <a href="{{route('users.follow', $user->id)}}" class="btn btn-primary rounded-pill">
                    @if(Auth::user()->isFollowing($user->id))
                    Unfollow
                    @else
                    Follow
                    @endif
                </a>
                @endif
                @if(Auth::user()->hasRole('admin'))
                <form action="{{route('dashboard.users.destroy', $user->id)}}" method="post" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger rounded-pill" type="submit">Delete user</button>
                </form>
                @endif
            </div>
        </div>

        @else
        <div class="d-flex justify-content-center">
            <h2 class="mx-auto mt-5 pt-5">User not found</h2>
        </div>
        @endif
    </x-bootstrap>
</x-app-layout>