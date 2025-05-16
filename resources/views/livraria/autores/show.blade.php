@extends('layouts.livraria')

@section('title', 'Autor: ' . $autor->nome)

@section('content')
<div class="bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-semibold mb-4">Autor</h1>
    <div class="mb-4">
        <strong>ID:</strong> {{ $autor->id }}
    </div>
    <div class="mb-4">
        <strong>Nome:</strong> {{ $autor->nome }}
    </div>
    <a href="{{ route('autores.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 px-4 rounded-lg">
        Voltar
    </a>
</div>
@endsection
