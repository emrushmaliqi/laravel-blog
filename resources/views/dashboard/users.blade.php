<x-dashboard-layout>
    <div class="container">
        <form action="{{Request::url()}}" method="get" class="d-flex w-25 my-3" role="search">
            <input class="form-control me-2" name="search" type="search" required placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-primary" type="submit">Search</button>
        </form>
        @if(count($users))
        <table class="table mx-auto">
            <thead>
                <tr>
                    <th scope="col">
                        @if($sort == "id")
                        <a href="?sort=id-@if($order == 'asc'){{'desc'}}@else{{'asc'}}@endif{{Request::has('search') ? '&search=' . Request::get('search'): ''}}">#
                            @if($order == 'asc')
                            <i class="bi bi-arrow-up-short"></i>
                            @else
                            <i class="bi bi-arrow-down-short"></i>
                            @endif
                        </a>
                        @else
                        <a href="?sort=id-asc{{Request::has('search') ? '&search=' . Request::get('search'): ''}}" class="text-black text-decoration-none">#</a>
                        @endif
                    </th>
                    <th scope="col">
                        @if($sort == "name")
                        <a href="?sort=name-@if($order == 'asc'){{'desc'}}@else{{'asc'}}@endif{{Request::has('search') ? '&search=' . Request::get('search'): ''}}">Name
                            @if($order == 'asc')
                            <i class="bi bi-arrow-up-short"></i>
                            @else
                            <i class="bi bi-arrow-down-short"></i>
                            @endif
                        </a>
                        @else
                        <a href="?sort=name-asc{{Request::has('search') ? '&search=' . Request::get('search'): ''}}" class="text-black text-decoration-none">Name</a>

                        @endif
                    </th>
                    <th scope="col">
                        @if($sort == "email")
                        <a href="?sort=email-@if($order == 'asc'){{'desc'}}@else{{'asc'}}@endif{{Request::has('search') ? '&search=' . Request::get('search'): ''}}">Email
                            @if($order == 'asc')
                            <i class="bi bi-arrow-up-short"></i>
                            @else
                            <i class="bi bi-arrow-down-short"></i>
                            @endif
                        </a>
                        @else
                        <a href="?sort=email-asc{{Request::has('search') ? '&search=' . Request::get('search'): ''}}" class="text-black text-decoration-none">Email</a>
                        @endif
                    </th>
                    <th scope="col">
                        @if($sort == "created_at")
                        <a href="?sort=created_at-@if($order == 'asc'){{'desc'}}@else{{'asc'}}@endif{{Request::has('search') ? '&search=' . Request::get('search'): ''}}">Signed up at
                            @if($order == 'asc')
                            <i class="bi bi-arrow-up-short"></i>
                            @else
                            <i class="bi bi-arrow-down-short"></i>
                            @endif
                        </a>
                        @else
                        <a href="?sort=created_at-asc{{Request::has('search') ? '&search=' . Request::get('search'): ''}}" class="text-black text-decoration-none">Signed up at</a>
                        @endif
                    </th>
                    <th scope="col">
                        @if($sort == "email_verified_at")
                        <a href="?sort=email_verified_at-@if($order == 'asc'){{'desc'}}@else{{'asc'}}@endif{{Request::has('search') ? '&search=' . Request::get('search'): ''}}">Email verified at
                            @if($order == 'asc')
                            <i class="bi bi-arrow-up-short"></i>
                            @else
                            <i class="bi bi-arrow-down-short"></i>
                            @endif
                        </a>
                        @else
                        <a href="?sort=email_verified_at-asc{{Request::has('search') ? '&search=' . Request::get('search'): ''}}" class="text-black text-decoration-none">Email verified at</a>
                        @endif
                    </th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <th scope="row">{{$user->id}}</th>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->created_at}}</td>
                    <td>{{$user->email_verified_at}}</td>
                    <td class="d-flex flex-column gap-2">
                        <a href="{{route('users.show', $user->id)}}" class="btn btn-primary">View user</a>
                        <a href="{{route('dashboard.posts', ['user' => $user->id])}}" class="btn btn-primary">Posts</a>
                        <a href="{{route('dashboard.comments', ['filter' => 'user-' . $user->id])}}" class="btn btn-primary">Comments</a>
                        <form action="{{route('dashboard.users.destroy', $user->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit"><i class="bi bi-trash"></i></button>
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <h4>No users found</h4>
        @endif
    </div>
</x-dashboard-layout>