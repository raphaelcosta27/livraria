<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    use HasFactory;

    protected $table = 'autores';

    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'nome',
    ];

    /**
     * Relacionamento N:N com Livro.
     * Um autor pode ter vários livros.
     */
    public function livros()
    {
        return $this->belongsToMany(Livro::class, 'livro_autor', 'autor_id', 'livro_id');
    }
}
