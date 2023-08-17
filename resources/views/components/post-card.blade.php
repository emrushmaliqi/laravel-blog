<div class="card" style="width: 16rem;">
    <div class="card-body d-flex flex-column justify-content-between">
        <div>
            <h5 class="card-title">{{$post->title}}</h5>
            <h6 class="card-subtitle mb-2 text-body-secondary">{{$post->created_at}}</h6>
        </div>
        <p class="card-text">{{ \Illuminate\Support\Str::limit($post->body, $limit= 100, $end = '...')}}</p>
        <a href="{{route('posts.show', $post->id)}}" class="btn btn-outline-primary align-self-start">Go to post</a>
    </div>
</div>