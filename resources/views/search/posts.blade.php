<x-app-layout>
    <x-bootstrap>
        <div class="container">
            <span>
                Posts search results for "{{$search}}"
            </span>

            <div class="d-flex gap-2">
                <form action="{{route('search.posts')}}" method="get">
                    <button name="search" value="{{$search}}" class="btn btn-outline-primary @if(request()->routeIs('search.posts')) active @endif">Posts</button>
                </form>
                <form action="{{route('search.users')}}" method="get">
                    <button name="search" value="{{$search}}" class="btn btn-outline-primary @if(request()->routeIs('search.users')) active @endif">Users</button>
                </form>
            </div>
            @if($posts->count() > 0)
            <div class="d-flex flex-wrap gap-3 justify-content-center mt-4">
                @foreach($posts as $post)
                <x-post-card :post="$post" />

                @endforeach
            </div>
            @else
            <h4>No posts to show</h4>
            @endif
        </div>
    </x-bootstrap>
</x-app-layout>