@include('layout.header')


This is homepage
@foreach ($data as $item)
{{ $item['title'] }}

@endforeach


@include('layout.footer')