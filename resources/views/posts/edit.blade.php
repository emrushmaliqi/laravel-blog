<x-app-layout>
    <x-bootstrap>
        <div class="container py-2">
            <h2 class="text-center  my-4">Edit Post</h2>
            <form action="{{route('posts.update', $post->id)}}" method="POST" enctype="multipart/form-data">
                @method('PUT')
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
                <div class="form-group">
                    <label for="images" class="btn btn-primary mt-2">Add Images</label>
                    <input type="file" accept="image/*" name="images[]" class="hidden" id="images" multiple="multiple" class="form-control">
                </div>
                <button class=" btn btn-primary mt-3" role="button">Update</button>
            </form>
            <div id="images-container"></div>



        </div>

        @if ($errors->any())
        <div class="position-fixed" style="bottom: 10px; right: 10px;">
            @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">{{ $error }}</div>
            @endforeach
        </div>
        @endif
        <script>
            const textArea = document.getElementById('content');
            textAreaAdjust(textArea);
            textArea.addEventListener("input", () => textAreaAdjust(textArea));

            function textAreaAdjust(element) {
                element.style.height = "1px";
                element.style.height = (25 + element.scrollHeight) + "px";
            }

            const imgInp = document.getElementById('images');
            const imgContainer = document.getElementById('images-container');

            imgInp.onchange = e => {
                const {
                    files
                } = imgInp;

                imgContainer.innerHTML = '<h5>Images</h5><div class="d-flex flex-wrap gap-2"></div>'

                for (image of files) {
                    imgContainer.querySelector('div').innerHTML += `<img id="img-${imgContainer.childElementCount + 1}" src="${URL.createObjectURL(image)}" style="max-height: 150px;"/>`
                }
            }
        </script>
    </x-bootstrap>

</x-app-layout>