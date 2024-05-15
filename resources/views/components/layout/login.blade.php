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

</head>

<body>
<main>
    {{ $slot }}

    @if (session('success'))
        <x-aim-admin::toast type="success" message="{{ session('success') }}"/>
    @elseif(session('info'))
        <x-aim-admin::toast type="info" message="{{ session('info') }}"/>
    @elseif(session('warning'))
        <x-aim-admin::toast type="warning" message="{{ session('warning') }}"/>
    @elseif(session('error'))
        <x-aim-admin::toast type="error" message="{{ session('error') }}"/>
    @endif
</main>
@stack('scripts')
</body>

</html>
