{{--Summernote inclusão do text area editor--}}
@section('plugins.Sweetalert2', true)

@if($errors->any())
    @push('js')
        <script>
            Swal.fire({
            icon: 'error',
            title: 'Erro!',
            text: '<ul>@foreach ($errors->all() as $error)'+
                    '<li>$error</li>'+
                '@endforeach'+
            '</ul>',
            })
        </script>
    @endpush
@endif

@if(session()->has('success'))
    @push('js')
        <script>
            Swal.fire({
            icon: 'success',
            title: 'Sucesso!',
            //timer: 3000,
            text: '{{ session()->get('success', 'default')}}.',
            })
        </script>
    @endpush
@endif

@if(session()->has('info'))
    @push('js')
        <script>
            Swal.fire({
            icon: 'info',
            title: 'Oops...',
            text: '{{ session()->get('info', 'default')}}!',
            })
        </script>
    @endpush
@endif