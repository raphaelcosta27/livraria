<x-flash-message type="error" :message="session('error')" />

<form 
    action="{{ isset($assunto) ? route('assuntos.update', $assunto) : route('assuntos.store') }}" 
    method="POST"
>
    @csrf
    @if(isset($assunto))
        @method('PUT')
    @endif

    <div class="mb-4">
        <label class="block text-gray-600 mb-2" for="descricao">Descrição</label>
        <input
            type="text"
            name="descricao"
            id="descricao"
            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-400"
            value="{{ old('descricao', $assunto->descricao ?? '') }}"
            required
        >
    </div>
    <div class="flex items-center justify-between">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            {{ isset($assunto) ? 'Atualizar' : 'Salvar' }}
        </button>
        <a href="{{ route('assuntos.index') }}" class="text-gray-500 hover:underline">Cancelar</a>
    </div>
</form>
