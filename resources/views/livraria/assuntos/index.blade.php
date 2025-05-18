@extends('layouts.livraria')

@section('content')
    <x-index-page title="Assuntos Cadastrados" createRoute="assuntos.create" createLabel="Novo Assunto">
        <x-card-table>
            
            @livewire('assuntos-table')
        </x-card-table>
    </x-index-page>

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
                form.action = '/assuntos/' + id;
                form.submit();
            }
        }
    </script>
@endpush
