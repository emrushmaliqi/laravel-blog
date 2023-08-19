<x-app-layout>
    <x-bootstrap>
        @if(null !== $post)
        <div class="container">
            <h4>{{$post->title}}</h4>
            <div>
                <h5>Author: <a href="{{route('users.show', $post->user->id)}}" class="text-decoration-none">{{$post->user->name}}</a></h5>
                <h5>Category: <a href="{{route('posts.category', $post->category->slug)}}" class="text-decoration-none">{{$post->category->name}}</a></h5>
                <h5>Created: {{$post->created_at}}</h5>
            </div>
            <div>
                <span>{{$post->likes->count()}}@if($post->likes->count() == 1) like @else likes @endif</span>
                @if(Auth::check())
                <a href="{{route('posts.like', $post->id)}}" class="btn btn-outline-danger">
                    @if($post->isLikedBy(Auth::user()))
                    Unlike <i class="bi bi-heart-fill"></i>
                    @else
                    Like <i class="bi bi-heart"></i>
                    @endif
                </a>
                @endif
            </div>
            @if(Auth::check())
            @if($post->isSaved())

            <a href="{{route('posts.save', $post->id)}}" id="save-btn" class="btn btn-outline-secondary">
                <i class="bi bi-bookmark-check-fill"></i>
            </a>

            @else

            <a href="{{route('posts.save', $post->id)}}" id="save-btn" class="btn btn-outline-secondary">
                <i class="bi bi-bookmark"></i>
            </a>

            @endif
            @endif
            <p>{!!nl2br($post->body)!!}</p>
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
            @if(Auth::check() && (Auth::user()->id === $post->user_id || Auth::user()->hasRole('admin')))
            <a class="btn btn-primary" href="{{route('posts.edit', $post->id)}}">Edit Post</a>
            <form action="{{route('posts.destroy', $post->id)}}" class="d-inline" method="POST">
                @method('DELETE')
                @csrf
                <button class="btn btn-danger" role="button">Delete Post</button>
            </form>
            @endif

            <div>
                <h5>Comments</h5>
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
                @foreach($post->comments as $comment)
                <div class="py-3">
                    <div class="d-flex align-items-center gap-2">
                        <a href="{{route('users.show', $comment->user->id)}}">
                            <img src="{{$comment->user->profile_photo_url}}" alt="{{$comment->user->name}} profile photo" class="rounded-circle" style="width: 40px; height: 40px; object-fit:cover">
                        </a>
                        <h6 class="m-0"><a href="{{route('users.show', $comment->user->id)}}" class="text-decoration-none">{{$comment->user->name}}</a> @if($comment->created_at != $comment->updated_at) <small class="text-muted">(edited)</small> @endif - commented {{$comment->created_at->diffForHumans()}}</h6>
                    </div>
                    <p>{{$comment->body}}</p>
                    <small>{{$comment->created_at}}</small>
                    @if(Auth::check() && (Auth::user()->id === $comment->user_id || Auth::user()->hasPermissionTo('delete_any_comment')))
                    <div class="d-flex gap-2">
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