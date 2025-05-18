<x-flash-message type="error" :message="session('error')" />

<form 
    action="{{ isset($autor) ? route('autores.update', $autor) : route('autores.store') }}" 
    method="POST"
>
    @csrf
    @if(isset($autor))
        @method('PUT')
    @endif

    <div class="mb-4">
        <label for="nome" class="block text-gray-600 mb-2">Nome</label>
        <input 
            type="text" 
            name="nome" 
            id="nome" 
            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-400 @error('nome') border-red-500 @enderror"
            value="{{ old('nome', $autor->nome ?? '') }}"
            required
        >
        @error('nome')
            <span class="text-red-600 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="flex items-center justify-between">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            {{ isset($autor) ? 'Atualizar' : 'Salvar' }}
        </button>
        <a href="{{ route('autores.index') }}" class="text-gray-500 hover:underline">Cancelar</a>
    </div>
</form>
