    <x-dashboard-layout>
        <div class="container">
            <div class="d-flex align-items-start gap-5">
                <form action="{{route('dashboard.posts')}}" method="get" class="d-flex w-50 my-3 gap-2" role="search">
                    <input class="form-control me-2 w-50" name="search" value="{{Request::get('search')}}" type="search" placeholder="Search by title" aria-label="Search">

                    <button type="submit" class="btn btn-outline-primary">Search</button>
                </form>
            </div>

            @if(count($comments))
            <table class="table mx-auto">
                <thead>
                    <tr>
                        <th scope="col" style="width: 47px;">
                            @if($sort == "id")
                            <a href="?sort=id-@if($order == 'asc'){{'desc'}}@else{{'asc'}}@endif{{Request::has('search') ? '&search=' . Request::get('search'): ''}}">#
                                @if($order == 'asc')
                                <i class="bi bi-arrow-up-short"></i>
                                @else
                                <i class="bi bi-arrow-down-short"></i>
                                @endif
                            </a>
                            @else
                            <a href="?sort=id-asc{{Request::has('search') ? '&search=' . Request::get('search'): ''}}{{Request::has('category') ? '&category=' . Request::get('category'): ''}}" class="text-black text-decoration-none">#</a>
                            @endif
                        </th>
                        <th scope="col">
                            @if($sort == "body")
                            <a href="?sort=body-@if($order == 'asc'){{'desc'}}@else{{'asc'}}@endif{{Request::has('search') ? '&search=' . Request::get('search'): ''}}">Comment
                                @if($order == 'asc')
                                <i class="bi bi-arrow-up-short"></i>
                                @else
                                <i class="bi bi-arrow-down-short"></i>
                                @endif
                            </a>
                            @else
                            <a href="?sort=body-asc{{Request::has('search') ? '&search=' . Request::get('search'): ''}}" class="text-black text-decoration-none">Comment</a>

                            @endif
                        </th>
                        <th scope="col">User</th>
                        <th scope="col">Post id</th>
                        <th scope="col">
                            @if($sort == "created_at")
                            <a href="?sort=created_at-@if($order == 'asc'){{'desc'}}@else{{'asc'}}@endif{{Request::has('search') ? '&search=' . Request::get('search'): ''}}">Created at
                                @if($order == 'asc')
                                <i class="bi bi-arrow-up-short"></i>
                                @else
                                <i class="bi bi-arrow-down-short"></i>
                                @endif
                            </a>
                            @else
                            <a href="?sort=created_at-asc{{Request::has('search') ? '&search=' . Request::get('search'): ''}}{{Request::has('category') ? '&category=' . Request::get('category'): ''}}" class="text-black text-decoration-none">Created at</a>
                            @endif
                        </th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($comments as $comment)
                    <tr>
                        <th scope="row">{{$comment->id}}</th>
                        <td>{{$comment->body}}</td>
                        <td><a href="{{route('users.show', $comment->user_id)}}" class="text-decoration-none text-black">{{$comment->user->name}}</a></td>
                        <td><a href="{{route('posts.show', $comment->post_id)}}" class="text-decoration-none text-black">{{$comment->post_id}}</a></td>
                        <td>{{$comment->created_at}}</td>
                        <td class="d-flex flex-column gap-2">
                            <a href="{{route('posts.show', $comment->post_id)}}" class="btn btn-primary ">View post</a>
                            <a href="{{route('users.show', $comment->user_id)}}" class="btn btn-primary">View user</a>
                            <form action="{{route('posts.comment.destroy',['post_id' => $comment->post_id, 'id' => $comment->id])}}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-danger w-100" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <h4>No comments found</h4>
            @endif
        </div>

        @if(Session::has('success'))
        <x-alert type="success">
            {{Session::get('success')}}
        </x-alert>
        @endif
    </x-dashboard-layout>