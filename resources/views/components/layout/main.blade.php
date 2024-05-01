<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if(isset($title))
        <title>{{ env('APP_NAME').':: '.$title ?? 'Aim Admin' }}</title>
    @else
        <title>{{env('APP_NAME')}}</title>
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script type="module">
        window.base_url = "{{ url('/') }}";
        window.csrf_token = "{{ csrf_token() }}";
    </script>
    @vite('resources/js/app.js')
    @stack('styles')
</head>
<body class="hold-transition sidebar-mini {{config('aim-admin.layout_class.body', '')}}">

<div class="wrapper">

    <!-- Navbar -->
    <x-aimadmin::navbar/>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <x-aimadmin::sidebar/>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        @isset($pageHeader)
                            {{$pageHeader}}
                        @endisset
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        @isset($breadcrumb)
                            {{$breadcrumb}}
                        @endisset
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        {{ $slot }}
        <!-- /.content -->

        @if(config('aim-admin.back_to_top', true))
            <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
                <i class="fas fa-chevron-up"></i>
            </a>
        @endif

    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <x-aimadmin::right-sidebar/>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <x-aimadmin::footer/>

</div>
<!-- ./wrapper -->
@if (session('success'))
    <x-aimadmin::toast type="success" message="{{ session('success') }}"/>
@elseif((session('info')))
    <x-aimadmin::toast type="info" message="{{ session('info') }}"/>
@elseif((session('warning')))
    <x-aimadmin::toast type="warning" message="{{ session('warning') }}"/>
@elseif((session('error')))
    <x-aimadmin::toast type="error" message="{{ session('error') }}"/>
@endif
@if($errors->any())
    @foreach ($errors->all() as $error)
        <x-aimadmin::toast type="error" message="{{ $error }}"/>
    @endforeach
@endif
@stack('scripts')
</body>
</html>
