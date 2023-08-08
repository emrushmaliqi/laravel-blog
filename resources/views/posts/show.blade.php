<x-app-layout>
    <x-bootstrap>
        @if(null !== $post)

        <div class="container">
            <h4>{{$post->title}}</h4>
            <div>
                <h5>Category: {{$post->category->name}}</h5>
                <h5>Author: {{$post->user->name}}</h5>
                <h5>Created: {{$post->created_at}}</h5>
            </div>
            <p>{!!nl2br($post->body)!!}</p>

            @if(Auth::user()->id === $post->user_id || Auth::user()->hasRole('admin'))
            <a class="btn btn-primary" href="{{route('posts.edit', $post->id)}}">Edit Post</a>
            <form action="{{route('posts.destroy', $post->id)}}" class="d-inline" method="POST">
                @method('DELETE')
                @csrf
                <button class="btn btn-danger" role="button">Delete Post</button>
            </form>
            @endif

            <div>
                <h5>Comments</h5>
                <form action="{{route('posts.comment', $post->id)}}" method="POST">
                    @csrf
                    <div class="form-group my-2">
                        <label for="comment">Add a comment</label>
                        <input type="text" name="comment" id="comment" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Comment</button>
                </form>
                @foreach($post->comments as $comment)
                <div class="py-3">
                    <div class="d-flex align-items-center gap-2">
                        <img src="{{$comment->user->profile_photo_url}}" alt="{{$comment->user->name}} profile photo" class="rounded-circle" style="width: 40px; height: 40px; object-fit:cover">
                        <h6 class="m-0">{{$comment->user->name}}</h6>
                    </div>
                    <p>{{$comment->body}}</p>
                    <small>{{$comment->created_at}}</small>
                    @if(Auth::user()->id === $comment->user_id || Auth::user()->hasPermissionTo('delete_any_comment'))
                    <form action="{{route('posts.comment.destroy', ['post_id' => $post->id, 'id' => $comment->id])}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger"><i class="bi bi-trash"></i></button>
                    </form>
                    @endif
                </div>

                @endforeach
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

</x-app-layout>
</x-bootstrap>