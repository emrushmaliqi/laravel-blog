<div class="alert alert-{{$type}}" style="position:fixed; right: 10px; bottom: 10px;">
    <!-- If you do not have a consistent goal in life, you can not live it in a consistent way. - Marcus Aurelius -->
    {{$slot}}
</div>

<script>
    setTimeout(() => {
        document.querySelector('.alert').style.opacity = 0;
    }, 3000)
</script>