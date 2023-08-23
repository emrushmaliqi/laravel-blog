<x-app-layout>
    <x-bootstrap>
        <div class="container">
            <nav class="my-3">
                <div class="d-flex justify-content-center gap-2">
                    @foreach($categories as $category)
                    <a href="{{route('posts.category', $category->slug)}}" class="btn btn-outline-primary @if(url()->current() == route('posts.category', $category->slug)) active @endif">{{$category->name}}</a>
                    @endforeach
                </div>
            </nav>
            <div class="d-flex flex-wrap justify-content-center gap-2 py-4">
                @foreach($posts as $post)
                <x-post-card :post="$post" />
                @endforeach
            </div>

            <div class="d-flex">
                <x-pagination :total-pages="$total_pages" :params="[]" />
            </div>
        </div>


        @if(Session::has('success'))
        <x-alert type="success">
            {{Session::get('success')}}
        </x-alert>
        @endif
    </x-bootstrap>
</x-app-layout>