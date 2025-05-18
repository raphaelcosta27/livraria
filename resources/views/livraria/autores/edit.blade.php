@extends('layouts.livraria')

@section('title', 'Editar  Autor')

@section('content')
    <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">Editar Autor</h2>
        @include('livraria.autores._form')
    </div>
@endsection
