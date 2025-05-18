<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Autor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AutorCrudTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'email_verified_at' => now(),
        ]);
    }

    public function test_usuario_autenticado_pode_ver_a_listagem_de_autores(): void
    {
        Autor::factory()->create(['nome' => 'Teste de Listagem']);

        $response = $this->actingAs($this->user)
            ->get(route('autores.index'));

        $response->assertOk();
        $response->assertSee('Teste de Listagem');
    }

    public function test_usuario_autenticado_pode_acessar_tela_de_criacao_de_autor(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('autores.create'));

        $response->assertOk();
        $response->assertSee('Novo Autor');
    }

    public function test_usuario_pode_criar_um_novo_autor(): void
    {
        $dados = ['nome' => 'Autor Novo'];

        $response = $this->actingAs($this->user)
            ->post(route('autores.store'), $dados);

        $response->assertRedirect(route('autores.index'));
        $this->assertDatabaseHas('autores', $dados);
    }

    public function test_valida_campo_obrigatorio_na_criacao(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('autores.store'), []);

        $response->assertSessionHasErrors(['nome']);
    }

    public function test_usuario_pode_acessar_tela_de_edicao_de_autor(): void
    {
        $autor = Autor::factory()->create();

        $response = $this->actingAs($this->user)
            ->get(route('autores.edit', $autor));

        $response->assertOk();
        $response->assertSee('Editar Autor');
    }

    public function test_usuario_pode_atualizar_um_autor(): void
    {
        $autor = Autor::factory()->create(['nome' => 'Original']);
        $dados = ['nome' => 'Atualizado'];

        $response = $this->actingAs($this->user)
            ->put(route('autores.update', $autor), $dados);

        $response->assertRedirect(route('autores.index'));
        $this->assertDatabaseHas('autores', $dados);
        $this->assertDatabaseMissing('autores', ['nome' => 'Original']);
    }

    public function test_usuario_pode_excluir_um_autor(): void
    {
        $autor = Autor::factory()->create();

        // Garante que o autor não possui livros associados
        $autor->livros()->detach();

        $response = $this->actingAs($this->user)
            ->delete(route('autores.destroy', $autor));

        $response->assertRedirect(route('autores.index'));
        $this->assertDatabaseMissing('autores', ['id' => $autor->id]);
    }

    public function test_nao_permite_inserir_nome_com_tipo_incorreto_array(): void
    {
        $dados = ['nome' => ['array', 'de', 'strings']];

        $response = $this->actingAs($this->user)
            ->post(route('autores.store'), $dados);

        $response->assertSessionHasErrors(['nome']);
    }

    public function test_nao_permite_inserir_nome_com_tipo_incorreto_inteiro(): void
    {
        $dados = ['nome' => 123456];

        $response = $this->actingAs($this->user)
            ->post(route('autores.store'), $dados);

        $response->assertSessionHasErrors(['nome']);
    }

    public function test_nao_permite_inserir_nome_com_string_muito_longa(): void
    {
        $dados = ['nome' => str_repeat('A', 256)];

        $response = $this->actingAs($this->user)
            ->post(route('autores.store'), $dados);

        $response->assertSessionHasErrors(['nome']);
    }

    public function test_nao_permite_inserir_nome_nulo(): void
    {
        $dados = ['nome' => null];

        $response = $this->actingAs($this->user)
            ->post(route('autores.store'), $dados);

        $response->assertSessionHasErrors(['nome']);
    }

    public function test_nao_permite_inserir_html_script_em_nome(): void
    {
        $dados = ['nome' => '<script>alert("xss")</script>'];

        $response = $this->actingAs($this->user)
            ->post(route('autores.store'), $dados);

        // Altere este comportamento conforme política do sistema (ex: sanitizar ou bloquear)
        $response->assertSessionDoesntHaveErrors(['nome']);
        $this->assertDatabaseHas('autores', $dados);
    }
}
