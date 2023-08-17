<x-dashboard-layout>
    <div class="container">
        <div class="d-flex my-3">
            <span class="ms-auto">Total likes: {{$total}}</span>
        </div>

        @if($likes->count())
        <table class="table mx-auto">
            <thead>
                <tr>
                    <th scope="col">
                        @if($sort == "user_id")
                        <a href="{{route('dashboard.likes', ['sort' => $order == 'asc' ? 'user_id-desc' : 'user_id-asc', 'filter' => Request::get('filter')])}}">User Id
                            @if($order == 'asc')
                            <i class="bi bi-arrow-up-short"></i>
                            @else
                            <i class="bi bi-arrow-down-short"></i>
                            @endif
                        </a>
                        @else
                        <a href="{{route('dashboard.likes', ['sort' => 'user_id-asc', 'filter' => Request::get('filter')])}}" class="text-black text-decoration-none">User Id</a>
                        @endif
                    </th>
                    <th scope="col">
                        @if($sort == "post_id")
                        <a href="{{route('dashboard.likes', ['sort' => $order == 'asc' ? 'post_id-desc' : 'post_id-asc', 'filter' => Request::get('filter')])}}">Post Id
                            @if($order == 'asc')
                            <i class="bi bi-arrow-up-short"></i>
                            @else
                            <i class="bi bi-arrow-down-short"></i>
                            @endif
                        </a>
                        @else
                        <a href="{{route('dashboard.likes', ['sort' => 'post_id-asc', 'filter' => Request::get('filter')])}}" class="text-black text-decoration-none">Post Id</a>
                        @endif
                    </th>
                    <th scope="col">
                        @if($sort == "created_at")
                        <a href="{{route('dashboard.likes', ['sort' => $order == 'asc' ? 'created_at-desc' : 'created_at-asc', 'filter' => Request::get('filter')])}}">Liked at
                            @if($order == 'asc')
                            <i class="bi bi-arrow-up-short"></i>
                            @else
                            <i class="bi bi-arrow-down-short"></i>
                            @endif
                        </a>
                        @else
                        <a href="{{route('dashboard.likes', ['sort' => 'created_at-asc', 'filter' => Request::get('filter')])}}" class="text-black text-decoration-none">Liked at</a>
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
        <x-pagination :params="['sort' => Request::get('sort'), 'filter' => Request::get('filter')]" :total-pages="ceil($total / $limit)" />

        @else
        <h4>No likes found</h4>
        @endif
    </div>
    @if(Session::has('success'))
    <x-alert type="success">{{Session::get('success')}}</x-alert>
    @endif
</x-dashboard-layout>