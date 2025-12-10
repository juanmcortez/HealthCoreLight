<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Health Core Light') }} - @yield('title', 'Authentication')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet"/>

    <!-- Scripts -->
    @vite(['resources/css/HealthCoreLight.css', 'resources/js/HealthCoreLight.js'])
</head>
<body class="antialiased bg-gradient-to-br from-primary-50 via-white to-secondary-50 min-h-screen">
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-4">
    <!-- Logo -->
    <div class="mb-4">
        <a href="/" class="flex items-center space-x-3">
            <div class="w-12 h-12 bg-gradient-to-br from-primary-600 to-secondary-600 rounded-xl flex items-center justify-center shadow-lg">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ __('Health Core Light') }}</h1>
                <p class="text-sm text-gray-600">{{ __('Healthcare Management System') }}</p>
            </div>
        </a>
    </div>

    @include('components.messages')

    <!-- Content Card -->
    <div class="w-full sm:max-w-md">
        <div class="bg-white shadow-2xl rounded-2xl overflow-hidden border border-gray-100">
            @yield('content')
        </div>

        <!-- Footer Links -->
        <div class="mt-6 text-center text-sm text-gray-600">
            @yield('footer-links')
        </div>
    </div>

    <!-- Copyright -->
    <div class="mt-8 text-center text-xs text-gray-500">
        &copy; {{ date('Y') }} {{ __('Health Core Light. All rights reserved.') }}
    </div>
</div>
</body>
</html>
