@extends('layouts.livraria')

@section('content')
    <x-index-page title="Livros Cadastrados" createRoute="livros.create" createLabel="Novo Livro">
        <x-card-table>
            @livewire('livros-table')
        </x-card-table>
    </x-index-page>

    {{-- Formulário oculto para exclusão --}}
    <form id="form-excluir-livro" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('scripts')
    <script>
        function confirmarExclusaoLivro(id, titulo) {
            if (confirm(`Tem certeza que deseja excluir o livro "${titulo}" (ID: ${id})?`)) {
                const form = document.getElementById('form-excluir-livro');
                form.action = '/livros/' + id;
                form.submit();
            }
        }
    </script>
@endpush
