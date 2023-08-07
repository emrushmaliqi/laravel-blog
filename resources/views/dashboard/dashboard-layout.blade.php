<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <x-bootstrap>
        <div class="d-flex mt-4">
            <nav class="d-flex flex-column gap-2 ms-2">
                <a href="{{route('dashboard.users')}}" class="btn btn-outline-primary">Users</a>
                <a href="{{route('dashboard.posts')}}" class="btn btn-outline-primary">Posts</a>
                <a href="{{route('dashboard.comments')}}" class="btn btn-outline-primary">Comments</a>
                <a href="{{route('categories.index')}}" class="btn btn-outline-primary">Categories</a>
            </nav>
            <div class="container">
                {{ $slot }}
            </div>
        </div>
    </x-bootstrap>
</x-app-layout>