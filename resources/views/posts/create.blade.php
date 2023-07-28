@include('layout.header')
<div class="container">
    <h2 class="text-center  my-4">Create Post</h2>
    <form action="{{route('posts.store')}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" />
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea name="content" id="content" style="overflow: hidden;" class="form-control" cols="30"></textarea>
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <select name="category" id="category" class="form-control">
                @foreach($categories as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
        </div>
        <button class=" btn btn-primary mt-3" role="button">Create</button>
    </form>
</div>
</div>




@include('layout.footer')