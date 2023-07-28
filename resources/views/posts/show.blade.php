@include('layout.header')

@if(null !== $post)

<div class="container">
    <h4>{{$post->title}}</h4>
    <div>
        <h5>Category: {{$post->category->name}}</h5>
        <h5>Author: {{$post->user->name}}</h5>
        <h5>Created: {{$post->created_at}}</h5>
    </div>
    <p>{!!nl2br($post->body)!!}</p>
    @if(true)
    <a class="btn btn-primary" href="{{route('posts.edit', $post->id)}}">Edit Post</a>
    <form action="{{route('posts.destroy', $post->id)}}" class="d-inline" method="POST">
        @method('DELETE')
        @csrf
        <button class="btn btn-danger" role="button">Delete Post</button>
    </form>
    @endif
    @if(null !== Session::get('success'))
    <div class="alert alert-success" style="position:fixed; bottom:10px; right:10px; transition: 300ms;" role="alert">
        {{Session::get('success')}}
    </div>

    <script>
        setTimeout(() => {
            document.querySelector('.alert').style.opacity = 0;
        }, 3000)
    </script>
    @endif
</div>

@else

<div class="container d-flex align-items-center flex-column">
    <h4>Post not found</h4>
    <a href="{{route('posts.index')}}" class="btn btn-primary">Go back to posts</a>
</div>

@endif

@include('layout.footer')