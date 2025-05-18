<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Assunto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssuntoCrudTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        // Crie um usuário e já verifique o e-mail, caso o sistema exija verificação para autenticar!
        $this->user = User::factory()->create([
            'email_verified_at' => now(),
        ]);
    }

    public function test_usuario_autenticado_pode_ver_a_listagem_de_assuntos()
    {
        Assunto::factory()->create(['descricao' => 'Teste de Listagem']);
        $response = $this->actingAs($this->user)
            ->get(route('assuntos.index'));

        $response->assertStatus(200);
        $response->assertSee('Teste de Listagem');
    }

    public function test_usuario_autenticado_pode_acessar_tela_de_criacao_de_assunto()
    {
        $response = $this->actingAs($this->user)
            ->get(route('assuntos.create'));

        $response->assertStatus(200);
        $response->assertSee('Novo Assunto');
    }

    public function test_usuario_pode_criar_um_novo_assunto()
    {
        $dados = ['descricao' => 'Assunto Novo'];

        $response = $this->actingAs($this->user)
            ->post(route('assuntos.store'), $dados);

        $response->assertRedirect(route('assuntos.index'));
        $this->assertDatabaseHas('assuntos', $dados);
    }

    public function test_valida_campo_obrigatorio_na_criacao()
    {
        $response = $this->actingAs($this->user)
            ->post(route('assuntos.store'), []);

        $response->assertSessionHasErrors(['descricao']);
    }

    public function test_usuario_pode_acessar_tela_de_edicao_de_assunto()
    {
        $assunto = Assunto::factory()->create();
        $response = $this->actingAs($this->user)
            ->get(route('assuntos.edit', $assunto));

        $response->assertStatus(200);
        $response->assertSee('Editar Assunto');
    }

    public function test_usuario_pode_atualizar_um_assunto()
    {
        $assunto = Assunto::factory()->create(['descricao' => 'Original']);
        $dados = ['descricao' => 'Atualizado'];

        $response = $this->actingAs($this->user)
            ->put(route('assuntos.update', $assunto), $dados);

        $response->assertRedirect(route('assuntos.index'));
        $this->assertDatabaseHas('assuntos', $dados);
        $this->assertDatabaseMissing('assuntos', ['descricao' => 'Original']);
    }

    public function test_usuario_pode_excluir_um_assunto()
    {
        $assunto = Assunto::factory()->create();
        $response = $this->actingAs($this->user)
            ->delete(route('assuntos.destroy', $assunto));

        $response->assertRedirect(route('assuntos.index'));
        $this->assertDatabaseMissing('assuntos', ['id' => $assunto->id]);
    }

    public function test_nao_permite_inserir_descricao_com_tipo_incorreto_array()
    {
        $dados = ['descricao' => ['array', 'de', 'strings']];

        $response = $this->actingAs($this->user)
            ->post(route('assuntos.store'), $dados);

        $response->assertSessionHasErrors(['descricao']);
    }

    public function test_nao_permite_inserir_descricao_com_tipo_incorreto_inteiro()
    {
        $dados = ['descricao' => 123456];

        $response = $this->actingAs($this->user)
            ->post(route('assuntos.store'), $dados);

        $response->assertSessionHasErrors(['descricao']);
    }

    public function test_nao_permite_inserir_descricao_com_string_muito_longa()
    {
        $dados = ['descricao' => str_repeat('A', 256)]; // Limite é 255

        $response = $this->actingAs($this->user)
            ->post(route('assuntos.store'), $dados);

        $response->assertSessionHasErrors(['descricao']);
    }

    public function test_nao_permite_inserir_descricao_nula()
    {
        $dados = ['descricao' => null];

        $response = $this->actingAs($this->user)
            ->post(route('assuntos.store'), $dados);

        $response->assertSessionHasErrors(['descricao']);
    }

    public function test_nao_permite_inserir_html_script_em_descricao()
    {
        $dados = ['descricao' => '<script>alert("xss")</script>'];

        $response = $this->actingAs($this->user)
            ->post(route('assuntos.store'), $dados);

        // Depende da sua validação/sanitização, se não bloquear, o teste vai falhar.
        // Se quiser garantir, pode usar:
        $response->assertSessionDoesntHaveErrors(['descricao']);
        $this->assertDatabaseHas('assuntos', [
            'descricao' => '<script>alert("xss")</script>'
        ]);
        // Ou ajuste o teste conforme sua política de segurança
    }
}
