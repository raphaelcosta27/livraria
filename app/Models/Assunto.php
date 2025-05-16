<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assunto extends Model
{
    use HasFactory;

    protected $table = 'assuntos';

    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'descricao',
    ];

    /**
     * Relacionamento N:N com Livro.
     * Um assunto pode estar relacionado a vários livros.
     */
    public function livros()
    {
        return $this->belongsToMany(Livro::class, 'livro_assunto', 'assunto_id', 'livro_id');
    }
}
