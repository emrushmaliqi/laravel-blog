<x-dashboard-layout>
    <div class="container">
        <table class="table mx-auto">
            <thead>
                <tr>
                    <th scope="col">
                        @if($sort == "user_id")
                        <a href="?sort=user_id-@if($order == 'asc'){{'desc'}}@else{{'asc'}}@endif{{Request::has('filter') ? '&filter=' . Request::get('filter'): ''}}">User Id
                            @if($order == 'asc')
                            <i class="bi bi-arrow-up-short"></i>
                            @else
                            <i class="bi bi-arrow-down-short"></i>
                            @endif
                        </a>
                        @else
                        <a href="?sort=user_id-asc{{Request::has('filter') ? '&filter=' . Request::get('filter'): ''}}" class="text-black text-decoration-none">User Id</a>
                        @endif
                    </th>
                    <th scope="col">
                        @if($sort == "post_id")
                        <a href="?sort=post_id-@if($order == 'asc'){{'desc'}}@else{{'asc'}}@endif{{Request::has('filter') ? '&filter=' . Request::get('filter'): ''}}">Post Id
                            @if($order == 'asc')
                            <i class="bi bi-arrow-up-short"></i>
                            @else
                            <i class="bi bi-arrow-down-short"></i>
                            @endif
                        </a>
                        @else
                        <a href="?sort=post_id-asc{{Request::has('filter') ? '&filter=' . Request::get('filter'): ''}}" class="text-black text-decoration-none">Post Id</a>
                        @endif
                    </th>
                    <th scope="col">
                        @if($sort == "created_at")
                        <a href="?sort=created_at-@if($order == 'asc'){{'desc'}}@else{{'asc'}}@endif{{Request::has('filter') ? '&filter=' . Request::get('filter'): ''}}">Liked at
                            @if($order == 'asc')
                            <i class="bi bi-arrow-up-short"></i>
                            @else
                            <i class="bi bi-arrow-down-short"></i>
                            @endif
                        </a>
                        @else
                        <a href="?sort=created_at-asc{{Request::has('filter') ? '&filter=' . Request::get('filter'): ''}}" class="text-black text-decoration-none">Liked at</a>
                        @endif
                    </th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($likes as $like)
                <tr>
                    <td scope="row">{{$like->user_id}}</td>
                    <td>{{$like->post_id}}</td>
                    <td>{{$like->created_at}}</td>
                    <td class="d-flex flex-column gap-2">
                        <a href="{{route('posts.show',$like->post_id)}}" class="btn btn-primary">View post</a>
                        <a href="{{route('users.show',$like->user_id)}}" class="btn btn-primary">View user</a>
                        <form action="{{route('dashboard.likes.destroy')}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="post_id" value="{{$like->post_id}}" id="post_id">
                            <input type="hidden" name="user_id" value="{{$like->user_id}}" id="user_id">
                            <button type="submit" class="btn btn-danger w-100"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if(Session::has('success'))
    <x-alert type="success">{{Session::get('success')}}</x-alert>
    @endif
</x-dashboard-layout>