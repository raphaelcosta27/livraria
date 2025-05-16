<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    use HasFactory;

    protected $table = 'livros';

    // Permite o preenchimento em massa dos campos abaixo
    protected $fillable = [
        'titulo',
        'editora',
        'edicao',
        'ano_publicacao',
        'valor',
    ];

    /**
     * Relacionamento N:N com Autor.
     * Um livro pode ter vários autores.
     */
    public function autores()
    {
        return $this->belongsToMany(Autor::class, 'livro_autor', 'livro_id', 'autor_id');
    }

    /**
     * Relacionamento N:N com Assunto.
     * Um livro pode ter vários assuntos.
     */
    public function assuntos()
    {
        return $this->belongsToMany(Assunto::class, 'livro_assunto', 'livro_id', 'assunto_id');
    }
}
