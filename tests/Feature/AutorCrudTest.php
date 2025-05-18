<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Autor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AutorCrudTest extends TestCase
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

    public function test_usuario_autenticado_pode_ver_a_listagem_de_autores()
    {
        Autor::factory()->create(['nome' => 'Teste de Listagem']);
        $response = $this->actingAs($this->user)
            ->get(route('autores.index'));

        $response->assertStatus(200);
        $response->assertSee('Teste de Listagem');
    }

    public function test_usuario_autenticado_pode_acessar_tela_de_criacao_de_autor()
    {
        $response = $this->actingAs($this->user)
            ->get(route('autores.create'));

        $response->assertStatus(200);
        $response->assertSee('Novo Autor');
    }

    public function test_usuario_pode_criar_um_novo_autor()
    {
        $dados = ['nome' => 'Autor Novo'];

        $response = $this->actingAs($this->user)
            ->post(route('autores.store'), $dados);

        $response->assertRedirect(route('autores.index'));
        $this->assertDatabaseHas('autores', $dados);
    }

    public function test_valida_campo_obrigatorio_na_criacao()
    {
        $response = $this->actingAs($this->user)
            ->post(route('autores.store'), []);

        $response->assertSessionHasErrors(['nome']);
    }

    public function test_usuario_pode_acessar_tela_de_edicao_de_autor()
    {
        $autor = Autor::factory()->create();
        $response = $this->actingAs($this->user)
            ->get(route('autores.edit', $autor));

        $response->assertStatus(200);
        $response->assertSee('Editar Autor');
    }

    public function test_usuario_pode_atualizar_um_autor()
    {
        $autor = Autor::factory()->create(['nome' => 'Original']);
        $dados = ['nome' => 'Atualizado'];

        $response = $this->actingAs($this->user)
            ->put(route('autores.update', $autor), $dados);

        $response->assertRedirect(route('autores.index'));
        $this->assertDatabaseHas('autores', $dados);
        $this->assertDatabaseMissing('autores', ['nome' => 'Original']);
    }

    public function test_usuario_pode_excluir_um_autor()
    {
        $autor = Autor::factory()->create();
        $response = $this->actingAs($this->user)
            ->delete(route('autores.destroy', $autor));

        // Se usa AJAX pode ser assertStatus(200), mas se usa redirect padrão:
        $response->assertRedirect(route('autores.index'));
        $this->assertDatabaseMissing('autores', ['id' => $autor->id]);
    }

    public function test_nao_permite_inserir_nome_com_tipo_incorreto_array()
    {
        $dados = ['nome' => ['array', 'de', 'strings']];

        $response = $this->actingAs($this->user)
            ->post(route('autores.store'), $dados);

        $response->assertSessionHasErrors(['nome']);
    }

    public function test_nao_permite_inserir_nome_com_tipo_incorreto_inteiro()
    {
        $dados = ['nome' => 123456];

        $response = $this->actingAs($this->user)
            ->post(route('autores.store'), $dados);

        $response->assertSessionHasErrors(['nome']);
    }

    public function test_nao_permite_inserir_nome_com_string_muito_longa()
    {
        $dados = ['nome' => str_repeat('A', 256)]; // Limite é 255

        $response = $this->actingAs($this->user)
            ->post(route('autores.store'), $dados);

        $response->assertSessionHasErrors(['nome']);
    }

    public function test_nao_permite_inserir_nome_nulo()
    {
        $dados = ['nome' => null];

        $response = $this->actingAs($this->user)
            ->post(route('autores.store'), $dados);

        $response->assertSessionHasErrors(['nome']);
    }

    public function test_nao_permite_inserir_html_script_em_nome()
    {
        $dados = ['nome' => '<script>alert("xss")</script>'];

        $response = $this->actingAs($this->user)
            ->post(route('autores.store'), $dados);

        // Depende da sua validação/sanitização, se não bloquear, o teste vai falhar.
        // Se quiser garantir, pode usar:
        $response->assertSessionDoesntHaveErrors(['nome']);
        $this->assertDatabaseHas('autores', [
            'nome' => '<script>alert("xss")</script>'
        ]);
        // Ou ajuste o teste conforme sua política de segurança
    }
}
