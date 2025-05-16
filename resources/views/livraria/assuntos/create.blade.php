{{-- resources/views/livraria/assuntos/create.blade.php --}}
@extends('layouts.livraria')

@section('title', 'Novo Assunto')

@section('content')
    <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">Novo Assunto</h2>

        @if($errors->any())
            <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
                <ul>
                    @foreach($errors->all() as $erro)
                        <li>{{ $erro }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @include('livraria.assuntos._form')
    </div>
@endsection
