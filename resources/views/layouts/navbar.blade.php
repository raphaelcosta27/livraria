<nav class="bg-gradient-to-r from-pink-800 to-indigo-900 text-white p-4 shadow-md">
    <div class="container mx-auto flex justify-between items-center">
        @auth
        <div class="flex items-center space-x-4">
            <a href="{{ route('livros.index') }}" class="text-lg font-semibold">{{ config('app.name') }}</a>
            <a href="{{ route('livros.index') }}" class="py-2 flex items-center gap-x-2">Livros</a>
            <a href="{{ route('autores.index') }}" class="py-2 flex items-center gap-x-2">Autores</a>
            <a href="{{ route('assuntos.index') }}" class="py-2 flex items-center gap-x-2">Assuntos</a>
            
            <!-- Dropdown Relatórios -->
            <div class="relative group">
                <button 
                    class="py-2 flex items-center gap-x-2 focus:outline-none group-hover:text-gray-200">
                    Relatórios
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div 
                    class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50 opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-200">
                    <a href="{{ route('relatorios.livros-autores') }}" 
                       class="block px-4 py-2 text-gray-800 hover:bg-indigo-100 hover:text-indigo-800 rounded-t-md">
                        Livros por Autores
                    </a>
                    <!-- Adicione outros itens aqui futuramente -->
                </div>
            </div>
        </div>
            
        <div class="flex items-center space-x-4">
            <span class="flex items-center gap-x-2 py-2">
                <i data-lucide="user" class="w-5 h-5"></i>{{ Auth::user()->name }}
            </span>
            <a href="{{ route('logout') }}" 
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="flex items-center gap-x-2 py-2">
                <i data-lucide="log-out" class="w-5 h-5"></i>Sair
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
        @endauth
    </div>
</nav>
