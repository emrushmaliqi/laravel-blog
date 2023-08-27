<x-app-layout>
    <x-bootstrap>
        @if(null !== $post)
        <div class="container d-flex flex-column align-items-center">
            <div class="w-50 mx-auto mt-5">
                <h1>{{$post->title}}</h1>
                <div>
                    <div class="d-flex align-items-center gap-1">
                        <img src="{{$post->user->profile_photo_url}}" alt="{{$post->user->name}} photo" class="rounded-circle" style="width:50px; height:50px; object-fit:cover;">
                        <h5 class="m-0"><a href="{{route('users.show', $post->user->id)}}" class="text-decoration-none">{{$post->user->name}}</a></h5>
                        <small class="text-secondary">{{$post->created_at->diffForHumans()}}</small>
                    </div>
                    <h5>Category: <a href="{{route('posts.category', $post->category->slug)}}" class="text-decoration-none">{{$post->category->name}}</a></h5>
                </div>
                <div>
                    <div class="d-inline">
                        <span>{{$post->likes->count()}}@if($post->likes->count() == 1) like @else likes @endif</span>
                        @if(Auth::check())
                        <a href="{{route('posts.like', $post->id)}}" class="btn btn-outline-secondary">
                            @if($post->isLikedBy(Auth::user()))
                            <i class="bi bi-hand-thumbs-up-fill"></i>
                            @else
                            <i class="bi bi-hand-thumbs-up"></i>
                            @endif
                        </a>
                        @endif
                    </div>
                    @if(Auth::check())
                    @if($post->isSaved())

                    <a href="{{route('posts.save', $post->id)}}" id="save-btn" class="btn btn-outline-secondary">
                        <i class="bi bi-bookmark-x-fill"></i>
                    </a>

                    @else

                    <a href="{{route('posts.save', $post->id)}}" id="save-btn" class="btn btn-outline-secondary">
                        <i class="bi bi-bookmark-plus"></i>
                    </a>
                    @endif
                    @endif
                    @if(Auth::check() && (Auth::user()->id === $post->user_id || Auth::user()->hasRole('admin')))
                    <a class="btn btn-primary" href="{{route('posts.edit', $post->id)}}">Edit Post</a>
                    <form action="{{route('posts.destroy', $post->id)}}" class="d-inline" method="POST">
                        @method('DELETE')
                        @csrf
                        <button class="btn btn-danger" role="button">Delete Post</button>
                    </form>
                    @endif
                </div>
            </div>
            <p class="mt-5">{!!nl2br($post->body)!!}</p>
            @if($post->images->count() > 0)
            <div class="d-flex flex-wrap gap-2 my-2">
                @if(Auth::check() && (Auth::user()->id === $post->user_id || Auth::user()->hasRole('admin')))
                @foreach($post->images as $image)
                <div class="position-relative">
                    <img src="{{$image->url()}}" class="img-fluid" style="height: 200px;" />
                    <form action="{{route('posts.image.destroy', ['post_id' => $post->id, 'id' => $image->id])}}" method="post" class="position-absolute" style="top: 5px; right: 5px;">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-outline-danger">Delete Image</button>
                    </form>
                </div>
                @endforeach
                @else
                @foreach($post->images as $image)
                <img src="{{$image->url()}}" class="img-fluid" style="height: 200px;" />
                @endforeach
                @endif
            </div>
            @endif

            <div class="w-75 mt-4 pb-3">
                <h4>Comments</h4>
                @if(Auth::check())
                <form action="{{route('posts.comment', $post->id)}}" method="POST">
                    @csrf
                    <div class="form-group my-2">
                        <label for="comment">Add a comment</label>
                        <input type="text" name="comment" id="comment" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Comment</button>
                </form>
                @endif
                @if($post->comments->count() > 0)
                <div>

                    @foreach($post->comments as $comment)
                    <div class="py-3 d-flex align-items-between">
                        <div>
                            <div class="d-flex align-items-center gap-2">
                                <a href="{{route('users.show', $comment->user->id)}}">
                                    <img src="{{$comment->user->profile_photo_url}}" alt="{{$comment->user->name}} profile photo" class="rounded-circle" style="width: 40px; height: 40px; object-fit:cover">
                                </a>
                                <h6 class="m-0"><a href="{{route('users.show', $comment->user->id)}}" class="text-decoration-none">{{$comment->user->name}}</a> @if($comment->created_at != $comment->updated_at) <small class="text-muted">(edited)</small> @endif - commented {{$comment->created_at->diffForHumans()}}</h6>
                            </div>
                            <p>{{$comment->body}}</p>
                        </div>
                        @if(Auth::check() && (Auth::user()->id === $comment->user_id || Auth::user()->hasPermissionTo('delete_any_comment')))
                        <div class="d-flex gap-2 align-items-center justify-content-end w-25">
                            <a class="btn btn-primary" href="{{route('posts.comment.edit', $comment->id)}}"><i class="bi bi-pencil"></i></a>
                            <form action="{{route('posts.comment.destroy', $comment->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                        @endif
                    </div>

                    @endforeach
                </div>
                @else
                <span>No comments yet</span>
                @endif
            </div>

            @if(Session::has('success'))
            <x-alert type="success">
                {{Session::get('success')}}
            </x-alert>

            @endif
        </div>
        @else

        <div class="container d-flex align-items-center flex-column">
            <h4>Post not found</h4>
            <a href="{{route('posts.index')}}" class="btn btn-primary">Go back to posts</a>
        </div>

        @endif




    </x-bootstrap>
    @if(Auth::check())
    <script>
        const saveBtn = document.querySelector('#save-btn')

        function toggleIcon() {
            const icon = saveBtn.querySelector('i');
            icon.classList.toggle('bi-bookmark-check-fill');
            icon.classList.toggle('bi-bookmark');
        }

        saveBtn.addEventListener('mouseenter', toggleIcon)
        saveBtn.addEventListener('mouseleave', toggleIcon)
    </script>

    @endif
</x-app-layout>