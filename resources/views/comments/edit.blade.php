<x-app-layout>
    <x-bootstrap>
        <div class="container py-2">
            <h2 class="text-center  my-4">Edit comment</h2>
            <form action="{{route('posts.comment.update', $comment->id)}}" method="POST">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="comment">Comment</label>
                    <textarea name="comment" id="comment" style="overflow: hidden;" class="form-control" cols="30">{{$comment->body}}</textarea>
                </div>
                <button class=" btn btn-primary mt-3" role="button">Update</button>
            </form>



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
        </script>
    </x-bootstrap>

</x-app-layout>