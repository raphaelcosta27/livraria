<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Livro;

class LivrosSeeder extends Seeder
{
    public function run()
    {
        $livros = [
            [
                'titulo' => 'Dom Casmurro',
                'editora' => 'Nova Fronteira',
                'edicao' => 1,
                'ano_publicacao' => '1899',
                'valor' => 29.90,
                'autores' => [1], // Machado de Assis
                'assuntos' => [1, 9], // Romance, Drama
            ],
            [
                'titulo' => 'Harry Potter e a Pedra Filosofal',
                'editora' => 'Rocco',
                'edicao' => 1,
                'ano_publicacao' => '1997',
                'valor' => 39.90,
                'autores' => [2], // J.K. Rowling
                'assuntos' => [3, 7], // Fantasia, Aventura
            ],
            [
                'titulo' => '1984',
                'editora' => 'Companhia das Letras',
                'edicao' => 1,
                'ano_publicacao' => '1949',
                'valor' => 34.90,
                'autores' => [3], // George Orwell
                'assuntos' => [2, 9], // Ficção Científica, Drama
            ],
            [
                'titulo' => 'O Senhor dos Anéis: A Sociedade do Anel',
                'editora' => 'Martins Fontes',
                'edicao' => 2,
                'ano_publicacao' => '1954',
                'valor' => 59.90,
                'autores' => [10], // J.R.R. Tolkien
                'assuntos' => [3, 7], // Fantasia, Aventura
            ],
            [
                'titulo' => 'Poesias Reunidas',
                'editora' => 'Record',
                'edicao' => 1,
                'ano_publicacao' => '1950',
                'valor' => 22.90,
                'autores' => [8, 4], // Cecília Meireles, Clarice Lispector
                'assuntos' => [6], // Poesia
            ],
            [
                'titulo' => 'O Pequeno Príncipe',
                'editora' => 'Agir',
                'edicao' => 3,
                'ano_publicacao' => '1943',
                'valor' => 19.90,
                'autores' => [5], // Antoine de Saint-Exupéry
                'assuntos' => [5, 1], // Infantil, Romance
            ],
            [
                'titulo' => 'A Revolução dos Bichos',
                'editora' => 'Companhia das Letras',
                'edicao' => 1,
                'ano_publicacao' => '1945',
                'valor' => 28.90,
                'autores' => [3], // George Orwell
                'assuntos' => [2, 9], // Ficção Científica, Drama
            ],
            [
                'titulo' => 'Capitães da Areia',
                'editora' => 'José Olympio',
                'edicao' => 2,
                'ano_publicacao' => '1937',
                'valor' => 26.50,
                'autores' => [6], // Jorge Amado
                'assuntos' => [1, 9], // Romance, Drama
            ],
        ];

        foreach ($livros as $livroData) {
            $autores = $livroData['autores'];
            $assuntos = $livroData['assuntos'];
            unset($livroData['autores'], $livroData['assuntos']);

            $livro = Livro::create($livroData);
            $livro->autores()->attach($autores);
            $livro->assuntos()->attach($assuntos);
        }
    }
}
