<x-app-layout>
    <x-bootstrap>
        <div class="container">
            <h4>Edit category</h4>

            <form action="{{route('categories.update', $category->id)}}" class="d-flex flex-column gap-2" method="post">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{$category->name}}">
                </div>
                <div class="form-group">
                    <label for="name">Slug</label>
                    <input type="text" name="slug" id="slug" class="form-control" value="{{$category->slug}}">
                </div>
                <button type="submit" class="btn btn-primary w-25">Update</button>
            </form>
        </div>
    </x-bootstrap>
</x-app-layout>