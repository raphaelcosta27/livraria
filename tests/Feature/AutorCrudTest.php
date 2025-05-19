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

        $response->assertSessionDoesntHaveErrors(['nome']);
        $this->assertDatabaseHas('autores', $dados);
    }

    // ---- TESTES DE SEGURANÇA ----

    public function test_nao_permite_sql_injection_no_nome(): void
    {
        $dados = ['nome' => "Autor'); DROP TABLE autores; --"];

        $response = $this->actingAs($this->user)
            ->post(route('autores.store'), $dados);

        $response->assertRedirect(route('autores.index'));
        $this->assertDatabaseHas('autores', ['nome' => "Autor'); DROP TABLE autores; --"]);
    }

    public function test_nao_permite_mass_assignment_em_campos_nao_fillable(): void
    {
        $dados = [
            'id'   => 999,
            'nome' => 'Mass Assignment',
            'criado_por' => 888,
        ];

        $response = $this->actingAs($this->user)
            ->post(route('autores.store'), $dados);

        $response->assertRedirect(route('autores.index'));
        $this->assertDatabaseHas('autores', ['nome' => 'Mass Assignment']);
        $this->assertDatabaseMissing('autores', ['id' => 999]);
    }

    public function test_nao_permite_sobrescrever_timestamps(): void
    {
        $dados = [
            'nome'       => 'Autor Timestamps',
            'created_at' => now()->addYear(),
            'updated_at' => now()->addYear(),
        ];

        $response = $this->actingAs($this->user)
            ->post(route('autores.store'), $dados);

        $response->assertRedirect(route('autores.index'));
        $this->assertDatabaseHas('autores', ['nome' => 'Autor Timestamps']);
        $this->assertDatabaseMissing('autores', [
            'created_at' => now()->addYear()->toDateTimeString()
        ]);
    }

    public function test_guest_nao_pode_criar_ou_excluir_autor(): void
    {
        $dados = ['nome' => 'Guest Autor'];

        $response = $this->post(route('autores.store'), $dados);
        $response->assertRedirect(route('login'));

        $autor = Autor::factory()->create();
        $response = $this->delete(route('autores.destroy', $autor));
        $response->assertRedirect(route('login'));
    }

    public function test_nao_permite_xss_em_nome(): void
    {
        $nomeMalicioso = '<img src=x onerror=alert("xss") />';
        $dados = ['nome' => $nomeMalicioso];

        $response = $this->actingAs($this->user)
            ->post(route('autores.store'), $dados);

        $response->assertRedirect(route('autores.index'));
        $this->assertDatabaseHas('autores', ['nome' => $nomeMalicioso]);
        // O front deve usar {{ $autor->nome }} para evitar execução
    }
}
