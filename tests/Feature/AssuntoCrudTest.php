<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Assunto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssuntoCrudTest extends TestCase
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

    public function test_usuario_autenticado_pode_ver_a_listagem_de_assuntos(): void
    {
        Assunto::factory()->create(['descricao' => 'Teste de Listagem']);

        $response = $this->actingAs($this->user)
            ->get(route('assuntos.index'));

        $response->assertOk();
        $response->assertSee('Teste de Listagem');
    }

    public function test_usuario_autenticado_pode_acessar_tela_de_criacao_de_assunto(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('assuntos.create'));

        $response->assertOk();
        $response->assertSee('Novo Assunto');
    }

    public function test_usuario_pode_criar_um_novo_assunto(): void
    {
        $dados = ['descricao' => 'Assunto Novo'];

        $response = $this->actingAs($this->user)
            ->post(route('assuntos.store'), $dados);

        $response->assertRedirect(route('assuntos.index'));
        $this->assertDatabaseHas('assuntos', $dados);
    }

    public function test_valida_campo_obrigatorio_na_criacao(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('assuntos.store'), []);

        $response->assertSessionHasErrors(['descricao']);
    }

    public function test_usuario_pode_acessar_tela_de_edicao_de_assunto(): void
    {
        $assunto = Assunto::factory()->create();

        $response = $this->actingAs($this->user)
            ->get(route('assuntos.edit', $assunto));

        $response->assertOk();
        $response->assertSee('Editar Assunto');
    }

    public function test_usuario_pode_atualizar_um_assunto(): void
    {
        $assunto = Assunto::factory()->create(['descricao' => 'Original']);
        $dados = ['descricao' => 'Atualizado'];

        $response = $this->actingAs($this->user)
            ->put(route('assuntos.update', $assunto), $dados);

        $response->assertRedirect(route('assuntos.index'));
        $this->assertDatabaseHas('assuntos', $dados);
        $this->assertDatabaseMissing('assuntos', ['descricao' => 'Original']);
    }

    public function test_usuario_pode_excluir_um_assunto(): void
    {
        $assunto = Assunto::factory()->create();

        $response = $this->actingAs($this->user)
            ->delete(route('assuntos.destroy', $assunto));

        $response->assertRedirect(route('assuntos.index'));
        $this->assertDatabaseMissing('assuntos', ['id' => $assunto->id]);
    }

    public function test_nao_permite_inserir_descricao_com_tipo_incorreto_array(): void
    {
        $dados = ['descricao' => ['array', 'de', 'strings']];

        $response = $this->actingAs($this->user)
            ->post(route('assuntos.store'), $dados);

        $response->assertSessionHasErrors(['descricao']);
    }

    public function test_nao_permite_inserir_descricao_com_tipo_incorreto_inteiro(): void
    {
        $dados = ['descricao' => 123456];

        $response = $this->actingAs($this->user)
            ->post(route('assuntos.store'), $dados);

        $response->assertSessionHasErrors(['descricao']);
    }

    public function test_nao_permite_inserir_descricao_com_string_muito_longa(): void
    {
        $dados = ['descricao' => str_repeat('A', 256)];

        $response = $this->actingAs($this->user)
            ->post(route('assuntos.store'), $dados);

        $response->assertSessionHasErrors(['descricao']);
    }

    public function test_nao_permite_inserir_descricao_nula(): void
    {
        $dados = ['descricao' => null];

        $response = $this->actingAs($this->user)
            ->post(route('assuntos.store'), $dados);

        $response->assertSessionHasErrors(['descricao']);
    }

    public function test_nao_permite_inserir_html_script_em_descricao(): void
    {
        $dados = ['descricao' => '<script>alert("xss")</script>'];

        $response = $this->actingAs($this->user)
            ->post(route('assuntos.store'), $dados);

        $response->assertSessionDoesntHaveErrors(['descricao']);
        $this->assertDatabaseHas('assuntos', $dados);
    }

    // ---- TESTES DE SEGURANÇA ----

    public function test_nao_permite_sql_injection_na_descricao(): void
    {
        $dados = ['descricao' => "Assunto'); DROP TABLE assuntos; --"];

        $response = $this->actingAs($this->user)
            ->post(route('assuntos.store'), $dados);

        $response->assertRedirect(route('assuntos.index'));
        $this->assertDatabaseHas('assuntos', ['descricao' => "Assunto'); DROP TABLE assuntos; --"]);
    }

    public function test_nao_permite_mass_assignment_em_campos_nao_fillable(): void
    {
        $dados = [
            'id'        => 888,
            'descricao' => 'Mass Assignment',
            'hack'      => 'não deveria salvar',
        ];

        $response = $this->actingAs($this->user)
            ->post(route('assuntos.store'), $dados);

        $response->assertRedirect(route('assuntos.index'));
        $this->assertDatabaseHas('assuntos', ['descricao' => 'Mass Assignment']);
        $this->assertDatabaseMissing('assuntos', ['id' => 888]);
    }

    public function test_nao_permite_sobrescrever_timestamps(): void
    {
        $dados = [
            'descricao'  => 'Timestamps',
            'created_at' => now()->addYear(),
            'updated_at' => now()->addYear(),
        ];

        $response = $this->actingAs($this->user)
            ->post(route('assuntos.store'), $dados);

        $response->assertRedirect(route('assuntos.index'));
        $this->assertDatabaseHas('assuntos', ['descricao' => 'Timestamps']);
        $this->assertDatabaseMissing('assuntos', [
            'created_at' => now()->addYear()->toDateTimeString()
        ]);
    }

    public function test_guest_nao_pode_criar_ou_excluir_assunto(): void
    {
        $dados = ['descricao' => 'Guest Teste'];

        $response = $this->post(route('assuntos.store'), $dados);
        $response->assertRedirect(route('login'));

        $assunto = Assunto::factory()->create();
        $response = $this->delete(route('assuntos.destroy', $assunto));
        $response->assertRedirect(route('login'));
    }

    public function test_nao_permite_xss_em_descricao(): void
    {
        $descricaoMaliciosa = '<img src=x onerror=alert("xss") />';
        $dados = ['descricao' => $descricaoMaliciosa];

        $response = $this->actingAs($this->user)
            ->post(route('assuntos.store'), $dados);

        $response->assertRedirect(route('assuntos.index'));
        $this->assertDatabaseHas('assuntos', ['descricao' => $descricaoMaliciosa]);
        // O front deve usar {{ $assunto->descricao }} para evitar execução
    }
}
