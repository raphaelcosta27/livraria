{{-- resources/views/livraria/assuntos/create.blade.php --}}
@extends('layouts.livraria')

@section('title', 'Novo Assunto')

@section('content')
    <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">Novo Assunto</h2>
        @include('livraria.assuntos._form')
    </div>
@endsection
