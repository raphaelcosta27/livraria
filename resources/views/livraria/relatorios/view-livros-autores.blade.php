@extends('layouts.livraria')

@section('content')
<div class="flex justify-center px-4 py-8">
    <div class="w-full">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Relatório de Livros por Autores</h1>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <livewire:relatorio-view-table/>
        </div>
    </div>
</div>
@endsection
