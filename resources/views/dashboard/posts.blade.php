<x-dashboard-layout>
    <div class="container">
        <div class="d-flex align-items-start gap-5">
            <form action="{{route('dashboard.posts')}}" method="get" class="d-flex w-50 my-3 gap-2" role="search">
                @if(Request::has('user'))
                <input type="hidden" name="user" value="{{Request::get('user')}}">
                @endif
                <input class="form-control me-2 w-50" name="search" value="{{Request::get('search')}}" type="search" placeholder="Search by title" aria-label="Search">
                <div class="form-group">
                    <label for="categories">Categories</label>
                    <select class="form-select" name="category" id="categories" aria-label="Default select example">
                        <option value="">All</option>
                        @foreach($categories as $category)
                        <option value="{{$category->id}}" @if(Request::get('category')==$category->id) selected @endif>{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-outline-primary">Search</button>
            </form>
            <span class="ms-auto align-self-center">Total posts: {{$total}}</span>
        </div>

        @if($posts->count())
        <table class="table mx-auto">
            <thead>
                <tr>
                    <th scope="col" style="width: 47px;">
                        @if($sort == "id")
                        <a href="{{route('dashboard.posts', array_merge($query_params, ['sort' => 'id-' . ($order == 'asc' ? 'desc' : 'asc')]))}}">#
                            @if($order == 'asc')
                            <i class="bi bi-arrow-up-short"></i>
                            @else
                            <i class="bi bi-arrow-down-short"></i>
                            @endif
                        </a>
                        @else
                        <a href="{{route('dashboard.posts', array_merge($query_params, ['sort' => 'id-asc']))}}" class="text-black text-decoration-none">#</a>
                        @endif
                    </th>
                    <th scope="col">
                        @if($sort == "title")
                        <a href="{{route('dashboard.posts', array_merge($query_params, ['sort' => 'title-' . ($order == 'asc' ? 'desc' : 'asc')]))}}">Title
                            @if($order == 'asc')
                            <i class="bi bi-arrow-up-short"></i>
                            @else
                            <i class="bi bi-arrow-down-short"></i>
                            @endif
                        </a>
                        @else
                        <a href="{{route('dashboard.posts', array_merge($query_params, ['sort' => 'title-asc']))}}" class="text-black text-decoration-none">Title</a>
                        @endif
                    </th>
                    <th scope="col">
                        @if($sort == "body")
                        <a href="{{route('dashboard.posts', array_merge($query_params, ['sort' => 'body-' . ($order == 'asc' ? 'desc' : 'asc')]))}}">Body
                            @if($order == 'asc')
                            <i class="bi bi-arrow-up-short"></i>
                            @else
                            <i class="bi bi-arrow-down-short"></i>
                            @endif
                        </a>
                        @else
                        <a href="{{route('dashboard.posts', array_merge($query_params, ['sort' => 'body-asc']))}}" class="text-black text-decoration-none">Body</a>
                        @endif
                    </th>
                    <th scope="col">User</th>
                    <th scope="col">Category</th>
                    <th scope="col">
                        @if($sort == "created_at")
                        <a href="{{route('dashboard.posts', array_merge($query_params, ['sort' => 'created_at-' . ($order == 'asc' ? 'desc' : 'asc')]))}}" class="d-flex">Posted at
                            @if($order == 'asc')
                            <i class="bi bi-arrow-up-short"></i>
                            @else
                            <i class="bi bi-arrow-down-short"></i>
                            @endif
                        </a>
                        @else
                        <a href="{{route('dashboard.posts', array_merge($query_params, ['sort' => 'created_at-asc']))}}" class="text-black text-decoration-none">Posted at</a>
                        @endif
                    </th>
                    <th scope="col" style="width:220px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                <tr>
                    <th scope="row">{{$post->id}}</th>
                    <td>{{$post->title}}</td>
                    <td style="overflow: auto; max-height: 80px !important">{{Str::limit($post->body, 300, $end='...')}}</td>
                    <td>{{$post->user->name}}</td>
                    <td>{{$post->category->name}}</td>
                    <td>{{$post->created_at}}</td>
                    <td class="d-flex flex-column gap-2" style="height:100%;">
                        <div class="d-flex gap-2">
                            <a href="{{route('posts.show', $post->id)}}" class="btn btn-primary w-50">View</a>
                            <a href="{{route('posts.edit', $post->id)}}" class="btn btn-warning w-50">Edit</a>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{route('dashboard.comments', ['filter' => 'post-' . $post->id])}}" class="btn btn-primary w-50">Comments</a>
                            <a href="{{route('dashboard.likes', ['filter' => 'post-' . $post->id])}}" class="btn btn-primary w-50">Likes</a>
                        </div>
                        <form action="{{route('posts.destroy', $post->id)}}" method="POST" class="w-100 d-flex justify-content-center">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-danger w-50" type="submit"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <x-pagination :params="array_merge($query_params, ['sort' => Request::get('sort')])" :total-pages="ceil($total / $limit)" />

        @else
        <h4>No posts found</h4>
        @endif
    </div>
</x-dashboard-layout>