@extends('layouts.livraria')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6 text-indigo-900">📊 Dashboard</h1>

    {{-- Indicadores --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-10">
        @foreach($cards as $card)
            <div class="bg-white rounded-lg shadow p-5">
                <h2 class="text-sm text-gray-600">{{ $card['label'] }}</h2>
                <p class="text-2xl font-bold text-indigo-700">{{ $card['value'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Gráficos --}}
    <div class="grid grid-cols-1 md:grid-cols-1 gap-6 mb-10">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 mb-6">
            {{-- Gráfico: Livros por Assunto --}}
            <div class="bg-white rounded-lg shadow p-4">
                <h3 class="text-lg font-semibold mb-2 text-gray-700">Livros por Assunto</h3>
                <canvas id="graficoAssuntos" class="h-64"></canvas>
            </div>

            {{-- Gráfico: Livros por Autor --}}
            <div class="bg-white rounded-lg shadow p-4">
                <h3 class="text-lg font-semibold mb-2 text-gray-700">Livros por Autor (Top 5)</h3>
                <canvas id="graficoAutores" class="h-64"></canvas>
            </div>

            {{-- Gráfico: Livros por Mês --}}
            <div class="bg-white rounded-lg shadow p-4">
                <h3 class="text-lg font-semibold mb-2 text-gray-700">Livros Cadastrados por Mês</h3>
                <canvas id="graficoMeses" class="h-64"></canvas>
            </div>

            {{-- Gráfico: Assuntos mais utilizados --}}
            <div class="bg-white rounded-lg shadow p-4">
                <h3 class="text-lg font-semibold mb-2 text-gray-700">Top 5 Assuntos Mais Utilizados</h3>
                <canvas id="graficoTopAssuntos" class="h-64"></canvas>
            </div>
        </div>
    </div>

    {{-- Últimos livros --}}
    <div class="bg-white rounded-lg shadow p-5">
        <h3 class="text-lg font-semibold mb-4 text-gray-700">Últimos Livros Cadastrados</h3>
        <ul>
            @foreach($ultimosLivros as $livro)
                <li class="border-b py-2">{{ $livro->titulo }} — <span class="text-sm text-gray-500">{{ $livro->created_at->format('d/m/Y') }}</span></li>
            @endforeach
        </ul>
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Livros por Assunto
    new Chart(document.getElementById('graficoAssuntos'), {
        type: 'bar',
        data: {
            labels: @json($dadosGraficoAssuntos->pluck('descricao')),
            datasets: [{
                label: 'Livros por Assunto',
                data: @json($dadosGraficoAssuntos->pluck('total')),
                backgroundColor: 'rgba(99, 102, 241, 0.6)',
                borderColor: 'rgba(99, 102, 241, 1)',
                borderWidth: 1
            }]
        }
    });

    // Livros por Autor
    new Chart(document.getElementById('graficoAutores'), {
        type: 'pie',
        data: {
            labels: @json($dadosGraficoAutores->pluck('nome')),
            datasets: [{
                data: @json($dadosGraficoAutores->pluck('total')),
                backgroundColor: ['#6366F1', '#EC4899', '#F59E0B', '#10B981', '#3B82F6']
            }]
        }
    });

    // Livros por Mês
    new Chart(document.getElementById('graficoMeses'), {
        type: 'line',
        data: {
            labels: @json($graficoPorMes->pluck('mes')),
            datasets: [{
                label: 'Cadastros',
                data: @json($graficoPorMes->pluck('total')),
                backgroundColor: 'rgba(59, 130, 246, 0.3)',
                borderColor: 'rgba(59, 130, 246, 1)',
                fill: true,
                tension: 0.4
            }]
        }
    });

    // Top Assuntos
    new Chart(document.getElementById('graficoTopAssuntos'), {
        type: 'doughnut',
        data: {
            labels: @json($graficoTopAssuntos->pluck('descricao')),
            datasets: [{
                data: @json($graficoTopAssuntos->pluck('total')),
                backgroundColor: ['#F87171', '#34D399', '#60A5FA', '#FBBF24', '#A78BFA']
            }]
        }
    });
</script>

@endsection
