<x-dashboard-layout>
    <div class="container">
        <div class="d-flex align-items-start gap-5">
            <form action="{{route('dashboard.users')}}" method="get" class="d-flex w-25 my-3" role="search">
                <input class="form-control me-2" name="search" value="{{Request::get('search')}}" type="search" required placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-primary" type="submit">Search</button>
            </form>
            <span class="ms-auto align-self-center">Total users: {{$total}}</span>
        </div>

        @if($users->count())
        <table class="table mx-auto">
            <thead>
                <tr>
                    <th scope="col">
                        @if($sort == "id")
                        <a href="{{route('dashboard.users', ['sort' => $order == 'asc' ? 'id-desc' : 'id-asc', 'search' => Request::get('search')])}}">#
                            @if($order == 'asc')
                            <i class="bi bi-arrow-up-short"></i>
                            @else
                            <i class="bi bi-arrow-down-short"></i>
                            @endif
                        </a>
                        @else
                        <a href="{{route('dashboard.users' , ['sort' => 'id-asc', 'search' => Request::get('search')])}}" class="text-black text-decoration-none">#</a>
                        @endif
                    </th>
                    <th scope="col">
                        @if($sort == "name")
                        <a href="{{route('dashboard.users', ['sort' => $order == 'asc' ? 'name-desc' : 'name-asc', 'search' => Request::get('search')])}}">Name
                            @if($order == 'asc')
                            <i class="bi bi-arrow-up-short"></i>
                            @else
                            <i class="bi bi-arrow-down-short"></i>
                            @endif
                        </a>
                        @else
                        <a href="{{route('dashboard.users' , ['sort' => 'name-asc', 'search' => Request::get('search')])}}" class="text-black text-decoration-none">Name</a>

                        @endif
                    </th>
                    <th scope="col">
                        @if($sort == "email")
                        <a href="{{route('dashboard.users', ['sort' => $order == 'asc' ? 'email-desc' : 'email-asc', 'search' => Request::get('search')])}}">Email
                            @if($order == 'asc')
                            <i class="bi bi-arrow-up-short"></i>
                            @else
                            <i class="bi bi-arrow-down-short"></i>
                            @endif
                        </a>
                        @else
                        <a href="{{route('dashboard.users' , ['sort' => 'email-asc', 'search' => Request::get('search')])}}" class="text-black text-decoration-none">Email</a>
                        @endif
                    </th>
                    <th scope="col">
                        @if($sort == "created_at")
                        <a href="{{route('dashboard.users', ['sort' => $order == 'asc' ? 'created_at-desc' : 'created_at-asc', 'search' => Request::get('search')])}}">Signed up at
                            @if($order == 'asc')
                            <i class="bi bi-arrow-up-short"></i>
                            @else
                            <i class="bi bi-arrow-down-short"></i>
                            @endif
                        </a>
                        @else
                        <a href="{{route('dashboard.users' , ['sort' => 'created_at-asc', 'search' => Request::get('search')])}}" class="text-black text-decoration-none">Signed up at</a>
                        @endif
                    </th>
                    <th scope="col">
                        @if($sort == "email_verified_at")
                        <a href="{{route('dashboard.users', ['sort' => $order == 'asc' ? 'email_verified_at-desc' : 'email_verified_at-asc', 'search' => Request::get('search')])}}">Email verified at
                            @if($order == 'asc')
                            <i class="bi bi-arrow-up-short"></i>
                            @else
                            <i class="bi bi-arrow-down-short"></i>
                            @endif
                        </a>
                        @else
                        <a href="{{route('dashboard.users' , ['sort' => 'email_verified_at-asc', 'search' => Request::get('search')])}}" class="text-black text-decoration-none">Email verified at</a>
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
                        <div class="d-flex gap-2">
                            <a href="{{route('users.show', $user->id)}}" class="btn btn-primary w-50">View profile</a>
                            <form action="{{route('dashboard.users.toggle-admin', $user->id)}}" method="post" class="w-50">
                                @csrf
                                <button type="submit" class="btn btn-primary w-100">{{$user->hasRole('admin') ? 'Remove admin' : 'Make admin'}}</button>
                            </form>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{route('dashboard.posts', ['user' => $user->id])}}" class="btn btn-primary w-50">Posts</a>
                            <a href="{{route('dashboard.comments', ['filter' => 'user-' . $user->id])}}" class="btn btn-primary w-50">Comments</a>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{route('dashboard.likes', ['filter' => 'user-' . $user->id])}}" class="btn btn-primary w-50">Likes</a>
                            <form action="{{route('dashboard.users.destroy', $user->id)}}" method="post" class="w-50">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger w-100" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <x-pagination :params="['sort' => Request::get('sort'), 'search' => Request::get('search')]" :total-pages="ceil($total / $limit)" />
        @if(Session::has('success'))
        <x-alert type="success">{{Session::get('success')}}</x-alert>
        @endif
        @else
        <h4>No users found</h4>
        @endif
    </div>
</x-dashboard-layout>