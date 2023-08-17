@if($totalPages > 1)
<nav class="mx-auto" aria-label="Page navigation example">
    <ul class="pagination">
        <li class="page-item"><a class="page-link @if(!Request::has('page') || Request::get('page')==1) disabled @endif" href="{{route(Route::current()->getName(), array_merge($params, ['page' => Request::get('page')-1], Route::current()->parameters))}}">Previous</a></li>
        <li class="page-item"><button class="page-link active" class="active">{{Request::has('page') ? Request::get('page') : 1}}</button></li>
        <li class="page-item"><a class="page-link @if(Request::get('page')==$totalPages) disabled @endif" href="{{route(Route::current()->getName(), array_merge($params, ['page' => Request::has('page') ? Request::get('page') +1 : 2], Route::current()->parameters))}}">Next</a></li>
    </ul>
</nav>
@endif