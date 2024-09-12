<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    {{-- <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap"> --}}

    <!-- Scripts -->
    @vite('resources/js/app.js')
    <style>
        .invalid-feedback {
            display: block !important;
        }
    </style>
</head>

<body>
<main>
    {{ $slot }}
</main>
<!-- ./wrapper -->
@php $toastTime = config('aim-admin.flash-timer', 2000); @endphp
@if (session('success'))
    <x-aim-admin::toast type="success" message="{{ session('success') }}" timer="{{session('flash-timer')??$toastTime}}"/>
@elseif((session('info')))
    <x-aim-admin::toast type="info" message="{{ session('info') }}" timer="{{session('flash-timer')??$toastTime}}"/>
@elseif((session('warning')))
    <x-aim-admin::toast type="warning" message="{{ session('warning') }}" timer="{{session('flash-timer')??$toastTime}}"/>
@elseif((session('error')))
    @if(config('aim-admin.show_toast_error', true))
        <x-aim-admin::toast type="error" message="{{ session('error') }}" timer="{{session('flash-timer')??$toastTime}}"/>
    @endif
@endif
@if(config('aim-admin.show_toast_error', true))
    @if($errors->any())
        @foreach ($errors->all() as $error)
            <x-aim-admin::toast type="error" message="{{ $error }}" timer="{{session('flash-timer')??$toastTime}}"/>
        @endforeach
    @endif
@endif
@stack('scripts')
</body>

</html>
