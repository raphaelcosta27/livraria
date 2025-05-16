@extends('layouts.livraria')

@section('content')
<div class="flex justify-center px-4 py-8">
    <div class="w-full">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Assuntos Cadastrados</h1>
            <a href="{{ route('assuntos.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Novo Assunto</a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-200 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        <div class="bg-white shadow-md rounded-lg p-6">
            @livewire('assuntos-table')
        </div>
    </div>
</div>

{{-- Formulário oculto para exclusão --}}
<form id="form-excluir-assunto" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
function confirmarExclusaoAssunto(id, titulo) {
    if (confirm(`Tem certeza que deseja excluir o assunto "${titulo}" (ID: ${id})?`)) {
        let form = document.getElementById('form-excluir-assunto');
        form.action = '/assuntos/' + id; // ajuste se sua rota for diferente!
        form.submit();
    }
}
</script>
@endpush
