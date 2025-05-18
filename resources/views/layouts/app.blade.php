<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @hasSection('title')
            <title>@yield('title') - {{ config('app.name') }}</title>
        @else
            <title>{{ $title ?? config('app.name') }}</title>
        @endif

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('/main-icon.png') }}">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
        @livewireScripts

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <body class="min-h-screen bg-slate-900">
        <div class="min-h-screen">
            @include('layouts.header')

            <!-- Page Content -->
            <main class="container mx-auto px-6 py-8">
                <livewire:error-handler />
                @yield('content')
            </main>
        </div>

        @stack('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </body>
</html>
