<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Livro;

class LivrosSeeder extends Seeder
{
    public function run()
    {
        // Exemplo 1
        $livro1 = Livro::create([
            'titulo' => 'Dom Casmurro',
            'data_lancamento' => '1899-01-01',
            'valor' => 29.90,
        ]);
        $livro1->autores()->attach([1]); // Machado de Assis
        $livro1->assuntos()->attach([1, 9]); // Romance, Drama

        // Exemplo 2
        $livro2 = Livro::create([
            'titulo' => 'Harry Potter e a Pedra Filosofal',
            'data_lancamento' => '1997-06-26',
            'valor' => 39.90,
        ]);
        $livro2->autores()->attach([2]); // J.K. Rowling
        $livro2->assuntos()->attach([3, 7]); // Fantasia, Aventura

        // Exemplo 3
        $livro3 = Livro::create([
            'titulo' => '1984',
            'data_lancamento' => '1949-06-08',
            'valor' => 34.90,
        ]);
        $livro3->autores()->attach([3]); // George Orwell
        $livro3->assuntos()->attach([2, 9]); // Ficção Científica, Drama

        // Exemplo 4
        $livro4 = Livro::create([
            'titulo' => 'O Senhor dos Anéis: A Sociedade do Anel',
            'data_lancamento' => '1954-07-29',
            'valor' => 59.90,
        ]);
        $livro4->autores()->attach([10]); // J.R.R. Tolkien
        $livro4->assuntos()->attach([3, 7]); // Fantasia, Aventura

        // Exemplo 5 (Livro com múltiplos autores)
        $livro5 = Livro::create([
            'titulo' => 'Poesias Reunidas',
            'data_lancamento' => '1950-01-01',
            'valor' => 22.90,
        ]);
        $livro5->autores()->attach([8, 4]); // Cecília Meireles e Clarice Lispector
        $livro5->assuntos()->attach([6]); // Poesia
    }
}
