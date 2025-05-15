<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AutorSeeder extends Seeder
{
    public function run()
    {
        DB::table('autores')->insert([
            ['nome' => 'Machado de Assis'],
            ['nome' => 'J.K. Rowling'],
            ['nome' => 'George Orwell'],
            ['nome' => 'Clarice Lispector'],
            ['nome' => 'Stephen King'],
            ['nome' => 'Agatha Christie'],
            ['nome' => 'José Saramago'],
            ['nome' => 'Cecília Meireles'],
            ['nome' => 'Paulo Coelho'],
            ['nome' => 'J.R.R. Tolkien'],
        ]);
    }
}
