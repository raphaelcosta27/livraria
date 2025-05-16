{{-- resources/views/livraria/livros/edit.blade.php --}}
@extends('layouts.livraria')

@section('content')
<div class="max-w-xl mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Editar Livro</h1>
    @include('livraria.livros._form')
</div>
@endsection
