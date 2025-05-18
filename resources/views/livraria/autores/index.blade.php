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
        @elseif(session('error'))
            <div class="mb-4 p-3 bg-red-200 text-red-800 rounded">{{ session('error') }}</div>
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
    <script>
        function enviarFormularioExclusaoAutor(id, nome) {
            if (confirm('Tem certeza que deseja excluir o autor "' + nome + '"? Esta ação não poderá ser desfeita.')) {
                var form = document.getElementById('form-excluir-autor');
                form.action = "{{ url('autores') }}/" + id;
                form.submit();
            }
        }
    </script>
@endpush
