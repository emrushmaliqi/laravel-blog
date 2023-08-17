<x-app-layout>
    <x-bootstrap>
        <div class="container">
            <div class="d-flex flex-wrap justify-content-center gap-2 my-3">
                @if($posts->count() > 0)
                @foreach($posts as $post)
                <x-post-card :post="$post" />
                @endforeach
                @else
                <h4 class="mt-5">No saved posts</h4>
                @endif
            </div>

        </div>

        <div class="d-flex">
            <x-pagination :total_pages="$total_pages" :params="[]" />

        </div>

        @if(Session::has('success'))
        <x-alert type="success">
            {{Session::get('success')}}
        </x-alert>
        @endif
    </x-bootstrap>
</x-app-layout>