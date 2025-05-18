<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Livro;
use App\Models\Autor;
use App\Models\Assunto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LivroCrudTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $autores;
    protected $assuntos;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'email_verified_at' => now(),
        ]);
        $this->autores = Autor::factory()->count(2)->create();
        $this->assuntos = Assunto::factory()->count(2)->create();
    }

    public function test_usuario_autenticado_pode_ver_listagem_de_livros()
    {
        $livro = Livro::factory()->create();
        $livro->autores()->attach($this->autores->pluck('id'));
        $livro->assuntos()->attach($this->assuntos->pluck('id'));

        $response = $this->actingAs($this->user)
            ->get(route('livros.index'));

        $response->assertStatus(200);
        $response->assertSee($livro->titulo);
    }

    public function test_usuario_autenticado_pode_acessar_tela_de_criacao_de_livro()
    {
        $response = $this->actingAs($this->user)
            ->get(route('livros.create'));

        $response->assertStatus(200);
        $response->assertSee('Cadastrar Livro');
    }

    public function test_usuario_pode_criar_um_novo_livro()
    {
        $dados = [
            'titulo'          => 'Livro Teste',
            'editora'         => 'Editora Top',
            'edicao'          => 1,
            'ano_publicacao'  => '2020',
            'valor'           => '19,99',
            'autores'         => $this->autores->pluck('id')->toArray(),
            'assuntos'        => $this->assuntos->pluck('id')->toArray(),
        ];

        $response = $this->actingAs($this->user)
            ->post(route('livros.store'), $dados);

        $response->assertRedirect(route('livros.index'));
        $this->assertDatabaseHas('livros', [
            'titulo' => 'Livro Teste',
            'editora' => 'Editora Top',
            'ano_publicacao' => '2020',
        ]);
    }

    public function test_nao_permite_cadastrar_livro_com_titulo_menor_que_3()
    {
        $dados = [
            'titulo'          => 'Li',
            'editora'         => 'Editora Teste',
            'edicao'          => 1,
            'ano_publicacao'  => '2020',
            'valor'           => '10,00',
            'autores'         => $this->autores->pluck('id')->toArray(),
            'assuntos'        => $this->assuntos->pluck('id')->toArray(),
        ];

        $response = $this->actingAs($this->user)
            ->post(route('livros.store'), $dados);

        $response->assertSessionHas('error', 'O título do livro deve ter pelo menos 3 caracteres.');
        $this->assertDatabaseMissing('livros', ['titulo' => 'Li']);
    }

    public function test_valida_campo_obrigatorio_na_criacao()
    {
        $response = $this->actingAs($this->user)
            ->post(route('livros.store'), []);

        $response->assertSessionHasErrors([
            'titulo', 'editora', 'edicao', 'ano_publicacao', 'valor', 'autores', 'assuntos'
        ]);
    }

    public function test_usuario_pode_acessar_tela_de_edicao()
    {
        $livro = Livro::factory()->create();
        $response = $this->actingAs($this->user)
            ->get(route('livros.edit', $livro->id));

        $response->assertStatus(200);
        $response->assertSee('Editar Livro');
    }

    public function test_usuario_pode_atualizar_um_livro()
    {
        $livro = Livro::factory()->create(['titulo' => 'Antigo']);
        $livro->autores()->attach($this->autores->pluck('id'));
        $livro->assuntos()->attach($this->assuntos->pluck('id'));

        $dados = [
            'titulo'          => 'Atualizado',
            'editora'         => 'Editora Nova',
            'edicao'          => 2,
            'ano_publicacao'  => '2021',
            'valor'           => '45,00',
            'autores'         => $this->autores->pluck('id')->toArray(),
            'assuntos'        => $this->assuntos->pluck('id')->toArray(),
        ];

        $response = $this->actingAs($this->user)
            ->put(route('livros.update', $livro->id), $dados);

        $response->assertRedirect(route('livros.index'));
        $this->assertDatabaseHas('livros', ['titulo' => 'Atualizado', 'editora' => 'Editora Nova']);
        $this->assertDatabaseMissing('livros', ['titulo' => 'Antigo']);
    }

    public function test_usuario_pode_excluir_um_livro()
    {
        $livro = Livro::factory()->create();
        $response = $this->actingAs($this->user)
            ->delete(route('livros.destroy', $livro->id));

        $response->assertRedirect(route('livros.index'));
        $this->assertDatabaseMissing('livros', ['id' => $livro->id]);
    }

    public function test_nao_permite_cadastrar_com_valor_invalido()
    {
        $dados = [
            'titulo'          => 'Livro Valor Inválido',
            'editora'         => 'Editora X',
            'edicao'          => 1,
            'ano_publicacao'  => '2020',
            'valor'           => 'abc',
            'autores'         => $this->autores->pluck('id')->toArray(),
            'assuntos'        => $this->assuntos->pluck('id')->toArray(),
        ];

        $response = $this->actingAs($this->user)
            ->post(route('livros.store'), $dados);

        $response->assertSessionHasErrors(['valor']);
        $this->assertDatabaseMissing('livros', ['titulo' => 'Livro Valor Inválido']);
    }

    public function test_nao_permite_atualizar_livro_inexistente()
    {
        $dados = [
            'titulo'          => 'Qualquer',
            'editora'         => 'Teste',
            'edicao'          => 1,
            'ano_publicacao'  => '2020',
            'valor'           => '15,00',
            'autores'         => $this->autores->pluck('id')->toArray(),
            'assuntos'        => $this->assuntos->pluck('id')->toArray(),
        ];

        $response = $this->actingAs($this->user)
            ->put(route('livros.update', 99999), $dados);

        $response->assertRedirect(route('livros.index'));
        $response->assertSessionHas('error', 'Livro não encontrado.');
    }

    public function test_nao_permite_excluir_livro_inexistente()
    {
        $response = $this->actingAs($this->user)
            ->delete(route('livros.destroy', 99999));

        $response->assertRedirect(route('livros.index'));
        $response->assertSessionHas('error', 'Livro não encontrado.');
    }

    public function test_nao_permite_criar_livro_com_ano_menor_que_1500_ou_maior_que_ano_atual()
    {
        $dadosMenor = [
            'titulo'          => 'Ano Antigo',
            'editora'         => 'Editora',
            'edicao'          => 1,
            'ano_publicacao'  => '1200',
            'valor'           => '10,00',
            'autores'         => $this->autores->pluck('id')->toArray(),
            'assuntos'        => $this->assuntos->pluck('id')->toArray(),
        ];

        $dadosMaior = [
            'titulo'          => 'Ano Futuro',
            'editora'         => 'Editora',
            'edicao'          => 1,
            'ano_publicacao'  => (string)(date('Y') + 1),
            'valor'           => '10,00',
            'autores'         => $this->autores->pluck('id')->toArray(),
            'assuntos'        => $this->assuntos->pluck('id')->toArray(),
        ];

        $response = $this->actingAs($this->user)
            ->post(route('livros.store'), $dadosMenor);
        $response->assertSessionHasErrors(['ano_publicacao']);

        $response = $this->actingAs($this->user)
            ->post(route('livros.store'), $dadosMaior);
        $response->assertSessionHasErrors(['ano_publicacao']);
    }

    public function test_nao_permite_criar_livro_com_campos_nulos()
    {
        $dados = [
            'titulo'          => null,
            'editora'         => null,
            'edicao'          => null,
            'ano_publicacao'  => null,
            'valor'           => null,
            'autores'         => [],
            'assuntos'        => [],
        ];

        $response = $this->actingAs($this->user)
            ->post(route('livros.store'), $dados);

        $response->assertSessionHasErrors([
            'titulo', 'editora', 'edicao', 'ano_publicacao', 'valor', 'autores', 'assuntos'
        ]);
    }

    public function test_valida_tipo_dos_campos()
    {
        $dados = [
            'titulo'          => 123,
            'editora'         => 456,
            'edicao'          => 'abc',
            'ano_publicacao'  => 'ano',
            'valor'           => 'vinte',
            'autores'         => 'não é array',
            'assuntos'        => 'também não',
        ];

        $response = $this->actingAs($this->user)
            ->post(route('livros.store'), $dados);

        $response->assertSessionHasErrors([
            'titulo', 'editora', 'edicao', 'ano_publicacao', 'valor', 'autores', 'assuntos'
        ]);
    }
}
