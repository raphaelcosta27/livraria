<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Projeto Livraria')</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        lucide.createIcons();
    });
</script>
<body class="bg-stone-200 flex flex-col min-h-screen">

    {{-- Importa a Navbar personalizada --}}
    @include('layouts.navbar')


    {{-- Container para manter o conteúdo expandível --}}
    <div class="container mx-auto p-5 flex-grow">
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
        <div class="container">
            @yield('content')
        </div>
    </div>

    {{-- Rodapé com Copyright --}}
    <footer class="text-center text-gray-600 text-sm py-4 mt-auto">
        &copy; {{ date('Y') }} Raphael Costa. Todos os direitos reservados.
    </footer>
    @stack('scripts')
    @livewireScripts
    @yield('scripts')
</body>
</html>
