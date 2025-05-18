<?php 

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class CreateVwRelatorioLivrosView extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (DB::getDriverName() === 'sqlite') {
            DB::statement("
                CREATE VIEW vw_relatorio_livros AS
                SELECT
                    a.id,
                    a.nome AS nome_autor,
                    l.id AS livro_id,
                    l.titulo AS titulo_livro,
                    l.editora,
                    l.edicao,
                    l.ano_publicacao,
                    l.valor,
                    GROUP_CONCAT(DISTINCT ass.descricao) AS assuntos
                FROM livros l
                INNER JOIN livro_autor la ON la.livro_id = l.id
                INNER JOIN autores a ON a.id = la.autor_id
                LEFT JOIN livro_assunto lsa ON lsa.livro_id = l.id
                LEFT JOIN assuntos ass ON ass.id = lsa.assunto_id
                GROUP BY a.id, a.nome, l.id, l.titulo, l.editora, l.edicao, l.ano_publicacao, l.valor
            ");
        } else {
            DB::statement("
                CREATE OR REPLACE VIEW vw_relatorio_livros AS
                SELECT
                    a.id,
                    a.nome AS nome_autor,
                    l.id AS livro_id,
                    l.titulo AS titulo_livro,
                    l.editora,
                    l.edicao,
                    l.ano_publicacao,
                    l.valor,
                    GROUP_CONCAT(DISTINCT ass.descricao ORDER BY ass.descricao SEPARATOR ', ') AS assuntos
                FROM livros l
                INNER JOIN livro_autor la ON la.livro_id = l.id
                INNER JOIN autores a ON a.id = la.autor_id
                LEFT JOIN livro_assunto lsa ON lsa.livro_id = l.id
                LEFT JOIN assuntos ass ON ass.id = lsa.assunto_id
                GROUP BY a.id, a.nome, l.id, l.titulo, l.editora, l.edicao, l.ano_publicacao, l.valor
                ORDER BY a.nome, l.titulo
            ");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_relatorio_livros");
    }
}
