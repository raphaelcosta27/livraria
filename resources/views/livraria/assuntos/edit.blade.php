{{-- resources/views/livraria/assuntos/edit.blade.php --}}
@extends('layouts.livraria')

@section('title', 'Editar Assunto')

@section('content')
    <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">Editar Assunto</h2>
        @include('livraria.assuntos._form', ['assunto' => $assunto])
    </div>
@endsection
