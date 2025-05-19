{{-- resources/views/welcome.blade.php --}}
@extends('layouts.livraria')

@section('title', 'Sistema de Livraria')

@section('content')
<img src="{{ asset('images/banner-livraria.png') }}" alt="Banner Livraria" class="w-full h-[400px] object-cover" />

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

    {{-- Seções de apresentação do projeto --}}

<div class="mt-20 grid grid-cols-1 md:grid-cols-2 gap-8">

    {{-- 1. Apresentação do Projeto --}}
    <div class="bg-white rounded-lg shadow-lg p-8 text-left border-l-4 border-indigo-500">
        <h2 class="text-2xl font-bold text-indigo-800 mb-2">O Projeto</h2>
        <p class="text-gray-700">
            Este sistema simula uma livraria digital, permitindo cadastro, consulta, edição e exclusão de livros, autores e assuntos. O objetivo é demonstrar boas práticas de desenvolvimento, usabilidade e organização, incluindo funcionalidades como filtros, relatórios e autenticação de usuários.
        </p>
    </div>

    {{-- 2. Tecnologias Utilizadas --}}
    <div class="bg-white rounded-lg shadow-lg p-8 text-left border-l-4 border-purple-500">
        <h2 class="text-2xl font-bold text-purple-800 mb-2">Tecnologias</h2>
        <ul class="list-disc list-inside text-gray-700 space-y-1">
            <li><b>Laravel</b> – Backend robusto e seguro</li>
            <li><b>Tailwind CSS</b> – Layout moderno e responsivo</li>
            <li><b>PowerGrid</b> – Tabelas interativas, rápidas e filtráveis</li>
            <li><b>jQuery</b> – Scripts leves para AJAX e UI</li>
        </ul>
    </div>

    {{-- 3. Segurança da Informação --}}
    <div class="bg-white rounded-lg shadow-lg p-8 text-left border-l-4 border-green-500">
        <h2 class="text-2xl font-bold text-green-800 mb-2">Segurança da Informação</h2>
        <ul class="list-disc list-inside text-gray-700 space-y-1">
            <li>Autenticação protegida via middleware</li>
            <li>Senhas criptografadas com bcrypt</li>
            <li>CSRF tokens em todos os formulários</li>
            <li>Validação rigorosa de dados do usuário</li>
            <li>Mensagens de erro específicas (sem leaks de detalhes técnicos)</li>
        </ul>
    </div>

    {{-- 4. Próximos Passos --}}
    <div class="bg-white rounded-lg shadow-lg p-8 text-left border-l-4 border-pink-500">
        <h2 class="text-2xl font-bold text-pink-800 mb-2">Próximos Passos</h2>
        <ul class="list-disc list-inside text-gray-700 space-y-1">
            <li>Implementação de permissões por perfil</li>
            <li>Exportação de relatórios em PDF</li>
            <li>Melhoria da cobertura de testes (TDD)</li>
            <li>Cadastro de editoras e usuários administradores</li>
            <li>Dashboard ainda mais detalhado</li>
        </ul>
    </div>

</div>
</div>
@endsection
