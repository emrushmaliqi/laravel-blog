<x-app-layout>
    <x-bootstrap>
        <div class="container">
            <h4>Create a category</h4>

            <form action="{{route('categories.store')}}" method="POST" class="d-flex flex-column gap-2">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" />
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" name="slug" id="slug" class="form-control" />
                </div>
                <button type="submit" class="btn btn-primary w-25">Create</button>
            </form>
        </div>
    </x-bootstrap>
</x-app-layout>