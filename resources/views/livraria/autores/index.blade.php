@extends('layouts.livraria')

@section('content')
    <x-index-page title="Autores Cadastrados" createRoute="autores.create" createLabel="Novo Autor">
        <x-card-table>
            @livewire('autores-table')
        </x-card-table>
    </x-index-page>

    {{-- Formulário oculto para exclusão --}}
    <form id="form-excluir-autor" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

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
