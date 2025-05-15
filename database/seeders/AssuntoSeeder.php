<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssuntoSeeder extends Seeder
{
    public function run()
    {
        DB::table('assuntos')->insert([
            ['descricao' => 'Romance'],
            ['descricao' => 'Ficção Científica'],
            ['descricao' => 'Fantasia'],
            ['descricao' => 'Mistério'],
            ['descricao' => 'Biografia'],
            ['descricao' => 'Poesia'],
            ['descricao' => 'Aventura'],
            ['descricao' => 'História'],
            ['descricao' => 'Drama'],
            ['descricao' => 'Autoajuda'],
        ]);
    }
}
