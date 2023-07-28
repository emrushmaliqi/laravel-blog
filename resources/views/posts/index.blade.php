@include('layout.header')

<div class="container">
    <div>
        <a href="{{route('posts.create')}}" class="btn btn-primary">Create a new post</a>
    </div>
    <div class="d-flex flex-wrap gap-2 my-3">
        @foreach($posts as $post)
        <div class="card" style="width: 16rem;">
            <div class="card-body">
                <h5 class="card-title">{{$post->title}}</h5>
                <h6 class="card-subtitle mb-2 text-body-secondary">{{$post->created_at}}</h6>
                <p class="card-text">{{ \Illuminate\Support\Str::limit($post->body, $limit= 100, $end = '...')}}</p>
                <a href="{{route('posts.show', $post->id)}}" class="card-link">Go to post</a>
            </div>
        </div>
        @endforeach
    </div>

</div>


@if(null !== Session::get('success'))
<div class="alert alert-success" style="position: fixed; bottom: 10px; right: 10px; transition: 300ms;" role="alert">
    {{Session::get('success')}}
</div>

<script>
    setTimeout(() => {
        document.querySelector('.alert').style.opacity = 0;
    }, 3000)
</script>
@endif


@include('layout.footer')