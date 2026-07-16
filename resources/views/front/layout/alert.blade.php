@if(session('message'))
    <script>
        iziToast.{{ session('type') }}({
            title: '{{ session('title') }}',
            message: '{{ session('message') }}',
            position: 'topCenter'
        });
    </script>
@endif
