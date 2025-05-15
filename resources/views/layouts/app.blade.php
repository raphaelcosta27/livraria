<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset
            @if (Breadcrumbs::exists())
                <nav class="ml-5 mt-4 text-gray-600 text-sm mb-4">
                    <ol class="flex items-center space-x-2">
                        @foreach (Breadcrumbs::generate() as $breadcrumb)
                            @if (!$loop->last)
                                <li>
                                    <a href="{{ $breadcrumb->url }}" class="text-blue-600 hover:underline">
                                        {{ $breadcrumb->title }}
                                    </a>
                                </li>
                                <li class="text-gray-400">›</li>
                            @else
                                <li class="text-gray-700 font-semibold">
                                    {{ $breadcrumb->title }}
                                </li>
                            @endif
                        @endforeach
                    </ol>
                </nav>
            @endif
            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    @livewireScripts
    </body>
</html>
