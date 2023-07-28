@include('layout.header')

<div class="container">
    <h2 class="text-center  my-4">Edit Post</h2>
    <form action="{{route('posts.update', $post->id)}}" method="POST">
        @method('PATCH')
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{$post->title}}" />
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea name="content" id="content" style="overflow: hidden;" class="form-control" cols="30">{{$post->body}}</textarea>
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <select name="category" id="category" class="form-control">
                @foreach($categories as $category)
                <option value="{{$category->id}}" @if($category->id == $post->category_id) selected @endif>{{$category->name}}</option>
                @endforeach
            </select>
        </div>
        <button class=" btn btn-primary mt-3" role="button">Update</button>
    </form>


</div>
<script>
    const textArea = document.getElementById('content');
    textAreaAdjust(textArea);
    textArea.addEventListener("input", () => textAreaAdjust(textArea));

    function textAreaAdjust(element) {
        element.style.height = "1px";
        element.style.height = (25 + element.scrollHeight) + "px";
    }
</script>


@include('layout.footer')