<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use App\Models\Autor;
use App\Models\Assunto;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Indicadores principais
        $totalLivros = Livro::count();
        $totalAutores = Autor::count();
        $totalAssuntos = Assunto::count();
        $valorTotalLivros = Livro::sum('valor');

        // Últimos livros cadastrados
        $ultimosLivros = Livro::latest()->take(5)->get();

        // Livros por Assunto
        $livrosPorAssunto = DB::table('assuntos')
            ->leftJoin('livro_assunto', 'assuntos.id', '=', 'livro_assunto.assunto_id')
            ->select('assuntos.descricao', DB::raw('count(livro_assunto.livro_id) as total'))
            ->groupBy('assuntos.descricao')
            ->orderByDesc('total')
            ->get();

        // Livros por Autor (top 5)
        $livrosPorAutor = DB::table('autores')
            ->leftJoin('livro_autor', 'autores.id', '=', 'livro_autor.autor_id')
            ->select('autores.nome', DB::raw('count(livro_autor.livro_id) as total'))
            ->groupBy('autores.nome')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Livros por Mês (últimos 6 meses)
        $livrosPorMes = Livro::selectRaw("DATE_FORMAT(created_at, '%m/%Y') as mes, COUNT(*) as total")
            ->groupBy('mes')
            ->orderByRaw("STR_TO_DATE(mes, '%m/%Y') ASC")
            ->limit(6)
            ->get();

        // Top 5 Assuntos mais usados
        $topAssuntos = DB::table('assuntos')
            ->join('livro_assunto', 'assuntos.id', '=', 'livro_assunto.assunto_id')
            ->select('assuntos.descricao', DB::raw('count(*) as total'))
            ->groupBy('assuntos.descricao')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return view('livraria.dashboard', [
            'cards' => [
                ['label' => 'Total de Livros', 'value' => $totalLivros],
                ['label' => 'Total de Autores', 'value' => $totalAutores],
                ['label' => 'Total de Assuntos', 'value' => $totalAssuntos],
                ['label' => 'Valor Total em Livros', 'value' => 'R$ ' . number_format($valorTotalLivros, 2, ',', '.')],
            ],
            'ultimosLivros' => $ultimosLivros,
            'dadosGraficoAssuntos' => $livrosPorAssunto,
            'dadosGraficoAutores' => $livrosPorAutor,
            'graficoPorMes' => $livrosPorMes,
            'graficoTopAssuntos' => $topAssuntos,
        ]);
    }
}
