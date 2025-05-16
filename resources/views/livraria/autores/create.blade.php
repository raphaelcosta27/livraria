@extends('layouts.livraria')

@section('title', 'Novo Autor')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-semibold mb-4">Novo Autor</h1>
    @include('livraria.autores._form')
</div>
@endsection
