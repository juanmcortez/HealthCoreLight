<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Health Core Light') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet"/>

    <!-- Scripts -->
    @vite(['resources/css/HealthCoreLight.css', 'resources/js/HealthCoreLight.js'])
</head>
<body class="antialiased bg-gray-50" x-data="{ sidebarOpen: false }">
<div class="min-h-screen">
    <!-- Sidebar -->
    @include('components.sidebar')

    <!-- Main Content Area -->
    <div class="lg:pl-64">
        <!-- Top Navbar -->
        @include('components.navbar')

        <!-- Page Content -->
        <main class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Breadcrumbs -->
                @if(isset($breadcrumbs))
                    @include('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
                @endif

                @include('components.messages')

                <!-- Page Content -->
                @yield('content')
            </div>
        </main>
    </div>
</div>
</body>
</html>
