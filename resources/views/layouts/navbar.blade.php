{{-- <nav class="bg-indigo-700 text-white p-4 shadow-md"> --}}
<nav class="bg-gradient-to-r from-pink-800 to-indigo-900 text-white p-4 shadow-md">
    <div class="container mx-auto flex justify-between items-center">
        @auth
        <div class="flex items-center space-x-4">
            <a href="{{ route('livros.index') }}" class="text-lg font-semibold">{{ config('app.name') }}</a>
            <a href="{{ route('livros.index') }}" class="py-2 flex items-center gap-x-2 ">Livros</a>
            <a href="{{ route('autores.index') }}" class="py-2 flex items-center gap-x-2 ">Autores</a>
            <a href="{{ route('assuntos.index') }}" class="py-2 flex items-center gap-x-2 ">Assuntos</a>
            </div>
            
            <div class="flex items-center space-x-4">
                <span class="flex items-center gap-x-2 py-2"><i data-lucide="user" class="w-5 h-5"></i>{{ Auth::user()->name }}</span>
                <a href="{{ route('logout') }}" 
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="flex items-center gap-x-2 py-2"><i data-lucide="log-out" class="w-5 h-5"></i>Sair
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
        @endauth
    </div>
</nav>
