{{-- resources/views/welcome.blade.php --}}
@extends('layouts.livraria')

@section('title', 'Sistema de Livraria')

@section('content')
<div class="container mx-auto px-4 py-12 text-center">
    <h1 class="text-4xl font-bold text-indigo-800 mb-6">Bem-vindo ao Sistema de Livraria</h1>
    <p class="text-lg text-gray-700 mb-10">Gerencie facilmente seus livros, autores e assuntos com praticidade e organização.</p>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <a href="{{ route('livros.index') }}" class="bg-indigo-600 text-white py-6 px-4 rounded-lg shadow-md hover:bg-indigo-700 transition">
            📚 Livros
        </a>
        <a href="{{ route('autores.index') }}" class="bg-purple-600 text-white py-6 px-4 rounded-lg shadow-md hover:bg-purple-700 transition">
            ✍️ Autores
        </a>
        <a href="{{ route('assuntos.index') }}" class="bg-pink-600 text-white py-6 px-4 rounded-lg shadow-md hover:bg-pink-700 transition">
            🧠 Assuntos
        </a>
    </div>

    <div class="mt-16">
        <a href="{{ route('relatorios.livros-autores') }}" class="text-indigo-700 underline hover:text-indigo-900 text-sm">📄 Ver Relatório de Livros</a>
    </div>
</div>
@endsection
