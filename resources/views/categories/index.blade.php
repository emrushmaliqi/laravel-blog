<x-dashboard-layout>
    <div class="container">

        <div class="d-flex justify-content-end">
            <a href="{{route('categories.create')}}" class="btn btn-primary my-2">Add Category</a>
        </div>
        @if(count($categories))
        <table class="table mx-auto">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Posts amount</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <th scope="row">{{$category->id}}</th>
                    <td>{{$category->name}}</td>
                    <td>{{$category->slug}}</td>
                    <td>{{$category->posts->count()}}</td>
                    <td>
                        <a href="{{route('dashboard.posts', ['category' => $category->id])}}" class="btn btn-primary">View posts</a>
                        <a href="{{route('categories.edit', ['category' => $category->id])}}" class="btn btn-warning">Edit</a>
                        <form action="{{route('categories.destroy', ['category' => $category->id])}}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <h4>No categories found</h4>
        @endif
    </div>
</x-dashboard-layout>