{{-- resources/views/livraria/livros/_form.blade.php --}}

@php
    $isEdit = isset($livro);
@endphp

<x-flash-message type="error" :message="session('error')" />

<form method="POST" action="{{ $isEdit ? route('livros.update', $livro->id) : route('livros.store') }}">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="mb-4">
        <label for="titulo" class="block font-medium">Título</label>
        <input type="text" name="titulo" id="titulo" class="w-full border rounded p-2" required maxlength="40"
               value="{{ old('titulo', $isEdit ? $livro->titulo : '') }}">
    </div>

    <div class="mb-4">
        <label for="editora" class="block font-medium">Editora</label>
        <input type="text" name="editora" id="editora" class="w-full border rounded p-2" required maxlength="40"
               value="{{ old('editora', $isEdit ? $livro->editora : '') }}">
    </div>

    <div class="mb-4">
        <label for="edicao" class="block font-medium">Edição</label>
        <input type="number" name="edicao" id="edicao" class="w-full border rounded p-2" required min="1"
               value="{{ old('edicao', $isEdit ? $livro->edicao : '') }}">
    </div>

    <div class="mb-4">
        <label for="ano_publicacao" class="block font-medium">Ano de Publicação</label>
        <input type="text" name="ano_publicacao" id="ano_publicacao"
               class="w-full border rounded p-2"
               required maxlength="4" pattern="\d{4}"
               value="{{ old('ano_publicacao', $isEdit ? $livro->ano_publicacao : '') }}">
    </div>

    <div class="mb-4">
        <label for="valor" class="block font-medium">Valor (R$)</label>
        <input type="text" name="valor" id="valor" class="w-full border rounded p-2" required
               value="{{ old('valor', $isEdit ? number_format($livro->valor, 2, ',', '.') : '') }}">
    </div>

    <div class="mb-4">
        <label class="block font-medium">Autores</label>
        <select name="autores[]" multiple class="w-full border rounded p-2" required>
            @foreach($autores as $autor)
                <option value="{{ $autor->id }}"
                    @if(
                        (is_array(old('autores')) && in_array($autor->id, old('autores'))) ||
                        ($isEdit && $livro->autores->pluck('id')->contains($autor->id))
                    ) selected @endif
                >{{ $autor->nome }}</option>
            @endforeach
        </select>
        <small>Segure CTRL para selecionar vários</small>
    </div>

    <div class="mb-4">
        <label class="block font-medium">Assuntos</label>
        <select name="assuntos[]" multiple class="w-full border rounded p-2" required>
            @foreach($assuntos as $assunto)
                <option value="{{ $assunto->id }}"
                    @if(
                        (is_array(old('assuntos')) && in_array($assunto->id, old('assuntos'))) ||
                        ($isEdit && $livro->assuntos->pluck('id')->contains($assunto->id))
                    ) selected @endif
                >{{ $assunto->descricao }}</option>
            @endforeach
        </select>
        <small>Segure CTRL para selecionar vários</small>
    </div>

    <div class="flex items-center justify-between">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            {{ $isEdit ? 'Atualizar' : 'Salvar' }}
        </button>
        <a href="{{ route('livros.index') }}" class="text-gray-500 hover:underline">Cancelar</a>
    </div>
        
    </button>
</form>

{{-- jQuery e plugins --}}
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
$(function() {
    // Máscara para valor em reais
    $('#valor').mask('000.000.000,00', {reverse: true});

    // Validação ano de publicação (apenas 4 dígitos, entre 1500 e o ano anterior ao atual)
    $('#ano_publicacao').on('input', function() {
        let valor = $(this).val();
        let ano = parseInt(valor, 10);
        let anoMin = 1500;
        let anoMax = {{ date('Y') }};

        if (valor.length > 0 && (isNaN(ano) || valor.match(/\D/))) {
            this.setCustomValidity('Digite apenas números para o ano.');
        } else if (ano < anoMin || ano > anoMax) {
            this.setCustomValidity('Ano deve ser entre ' + anoMin + ' e ' + anoMax + '.');
        } else {
            this.setCustomValidity('');
        }
    });
});
</script>
@endpush
