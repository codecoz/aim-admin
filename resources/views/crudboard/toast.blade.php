<script type="module">
    swal.fire({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        showCloseButton: true,
        didOpen: (toast) => {
            toast.onmouseenter = swal.stopTimer;
            toast.onmouseleave = swal.resumeTimer;
        },
        timer: {{$timer??2000}},
        timerProgressBar: true,
        icon: '{{ $type }}',
        title: '{{ $message }}'
    })

</script>

{{--  Toast.fire({
        icon: 'success',
        title: 'Success'
    })
    Toast.fire({
        icon: 'error',
        title: 'Error'
    })
    Toast.fire({
        icon: 'warning',
        title: 'Warning'
    })
    Toast.fire({
        icon: 'info',
        title: 'Info'
    })
    Toast.fire({
        icon: 'question',
        title: 'Question'
    }) --}}
