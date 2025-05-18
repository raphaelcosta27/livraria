{{-- resources/views/livraria/livros/create.blade.php --}}
@extends('layouts.livraria')

@section('content')
<div class="max-w-xl mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Cadastrar Livro</h1>
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-200 text-green-800 rounded">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="mb-4 p-3 bg-red-200 text-red-800 rounded">{{ session('error') }}</div>  
    @endif
    @include('livraria.livros._form')
</div>
@endsection