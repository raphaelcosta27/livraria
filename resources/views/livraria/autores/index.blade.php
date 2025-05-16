@extends('layouts.livraria')

@section('content')
<div class="flex justify-center px-4 py-8">
    <div class="w-full">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Autores Cadastrados</h1>
            <a href="{{ route('autores.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Novo Autor</a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-200 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        <div class="bg-white shadow-md rounded-lg p-6">
            @livewire('autores-table')
        </div>
    </div>
</div>

{{-- Formulário oculto para exclusão --}}
<form id="form-excluir-autor" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>
@endsection

{{-- ... layout e conteúdo igual ao seu ... --}}

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
function confirmarExclusaoAutor(id, nome) {
    if(confirm('Tem certeza que deseja excluir o autor "' + nome + '"? Esta ação não poderá ser desfeita.')) {
        $.ajax({
            url: "{{ url('autores') }}/" + id,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                alert(response.message || 'Autor excluído com sucesso!');
                Livewire.emit('pg:eventRefresh-autores-table');
            },
            error: function(xhr) {
                let mensagem = 'Erro ao excluir autor.';
                if(xhr.responseJSON && xhr.responseJSON.message) {
                    mensagem = xhr.responseJSON.message;
                }
                alert(mensagem);
            }
        });
    }
}
</script>
@endpush
