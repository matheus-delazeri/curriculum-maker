<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Curriculum Maker') }}</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" sizes="any" type="image/svg+xml">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased" x-data="{ darkMode: @json(Auth::user()->getTheme() === 'dark')}" x-init="
    window.addEventListener('theme-updated', event => {
        darkMode = event.detail.theme === 'dark';
    });
">
<div x-bind:class="{'dark' : darkMode === true}">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <livewire:layout.navigation/>

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            @if (session()->has('success-message'))
                <div class="pt-6">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div
                            class="flex items-center p-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                            role="alert">
                            <div class="ms-3 text-sm font-medium">
                                {{ __(session('success-message')) }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if (session()->has('error-message'))
                <div class="pt-6">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div
                            class="flex items-center p-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-green-400"
                            role="alert">
                            <div class="ms-3 text-sm font-medium">
                                {{ __(session('error-message')) }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            {{ $slot }}
        </main>
    </div>
</div>
</body>
</html>
