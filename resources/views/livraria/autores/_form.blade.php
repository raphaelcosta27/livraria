<form action="{{ isset($autore) ? route('autores.update', $autore) : route('autores.store') }}" method="POST">
    @csrf
    @if(isset($autore))
        @method('PUT')
    @endif

    <div class="mb-4">
        <label for="nome" class="block font-semibold mb-1">Nome</label>
        <input type="text" name="nome" id="nome" value="{{ old('nome', $autore->nome ?? '') }}"
               class="w-full p-2 border border-gray-300 rounded-lg @error('nome') border-red-500 @enderror">
        @error('nome')
            <span class="text-red-600 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="flex gap-2">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
            Salvar
        </button>
        <a href="{{ route('autores.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 px-4 rounded-lg">
            Cancelar
        </a>
    </div>
</form>