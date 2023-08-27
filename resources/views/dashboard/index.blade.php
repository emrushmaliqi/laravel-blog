<x-dashboard-layout>
    <div class="container d-flex flex-column gap-3">
        <div class="fs-5">
            <span>Total users:</span> <strong>{{$total_users}}</strong>
        </div>
        <div class="fs-5">
            <span>Total posts:</span> <strong>{{$total_posts}}</strong>
        </div>
        <div class="fs-5">
            <span>Total comments:</span> <strong>{{$total_comments}}</strong>
        </div>
        <div class="fs-5">
            <span>Total likes:</span> <strong>{{$total_likes}}</strong>
        </div>
        <div class="fs-5">
            <span>Total categories:</span> <strong>{{$total_categories}}</strong>
        </div>
    </div>
</x-dashboard-layout>