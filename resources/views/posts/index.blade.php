<x-app-layout>
    <x-bootstrap>
        <div class="container">
            <nav>
                <h3 class="text-center">Categories</h3>
                <div class="d-flex justify-content-center gap-2">
                    @foreach($categories as $category)
                    <a href="{{route('posts.category', $category->slug)}}" class="btn btn-outline-primary @if(url()->current() == route('posts.category', $category->slug)) active @endif">{{$category->name}}</a>
                    @endforeach
                </div>
            </nav>
            <div>
                <a href="{{route('posts.create')}}" class="btn btn-primary">Create a new post</a>
            </div>
            <div class="d-flex flex-wrap justify-content-center gap-2 my-3">
                @foreach($posts as $post)
                <x-post-card :post="$post" />
                @endforeach
            </div>

        </div>


        @if(Session::has('success'))
        <x-alert type="success">
            {{Session::get('success')}}
        </x-alert>
        @endif
    </x-bootstrap>
</x-app-layout>