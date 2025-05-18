<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use App\Models\Autor;
use App\Models\Assunto;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use App\Exceptions\LivroException;
use Illuminate\Validation\ValidationException;

class LivroController extends Controller
{
    /**
     * Retorna os dados do livro para inserção/atualização.
     *
     * @param Request $request
     * @return array
     */
    private function livroFields(Request $request): array
    {
        $valorFloat = $this->converterValor($request->input('valor'));
        return $request->except(['valor', 'autores', 'assuntos']) + ['valor' => $valorFloat];
    }

    /**
     * Valida a requisição e aplica regras de negócio específicas.
     *
     * @param Request $request
     * @throws LivroException
     */
    private function validar(Request $request)
    {
        $request->validate([
            'titulo'          => 'required|string|max:40',
            'editora'         => 'required|string|max:40',
            'edicao'          => 'required|integer|min:1',
            'ano_publicacao'  => 'required|digits:4|integer|between:1500,' . (date('Y')),
            'valor'           => ['required', 'regex:/^\d{1,3}(\.\d{3})*,\d{2}$/'],
            'autores'         => 'required|array|min:1',
            'assuntos'        => 'required|array|min:1',
        ]);

        $this->checaNegociosLivro($request);
    }

    /**
     * Lança exceção caso o título do livro não tenha pelo menos 3 caracteres.
     *
     * @param Request $request
     * @throws LivroException
     */
    private function checaNegociosLivro(Request $request)
    {
        if (strlen(trim($request->input('titulo'))) < 3) {
            throw new LivroException('O título do livro deve ter pelo menos 3 caracteres.');
        }
    }

    /**
     * Converte o valor do formato brasileiro para float.
     *
     * @param string $valorBR
     * @return float
     */
    private function converterValor($valorBR)
    {
        return floatval(str_replace(',', '.', str_replace('.', '', $valorBR)));
    }

    /**
     * Obtém todos os autores e assuntos.
     *
     * @return array
     */
    private function getAutoresAssuntos()
    {
        return [
            'autores' => Autor::all(),
            'assuntos' => Assunto::all(),
        ];
    }

    /**
     * Exibe a listagem de livros.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $livros = Livro::with(['autores', 'assuntos'])->paginate(10);
        return view('livraria.livros.index', compact('livros'));
    }

    /**
     * Exibe o formulário de criação de livros.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('livraria.livros.create', $this->getAutoresAssuntos());
    }

    /**
     * Armazena um novo livro.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $this->validar($request);

            $livro = Livro::create($this->livroFields($request));
            $livro->autores()->sync($request->autores);
            $livro->assuntos()->sync($request->assuntos);

            return redirect()->route('livros.index')->with('success', 'Livro cadastrado!');
        } catch (LivroException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        } catch (ValidationException $e) {
            throw $e; // Deixa o Laravel lidar e preencher a session com os erros!
        } catch (QueryException $e) {
            Log::error('Erro de banco ao cadastrar livro', ['erro' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Erro ao cadastrar livro. Tente novamente ou contate o suporte.');
        } catch (\Exception $e) {
            Log::critical('Erro inesperado ao cadastrar livro', ['erro' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Erro inesperado. Tente novamente.');
        }
    }

    /**
     * Exibe o formulário de edição de um livro.
     *
     * @param int $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        try {
            $livro = Livro::with(['autores', 'assuntos'])->findOrFail($id);
            return view('livraria.livros.edit', array_merge(['livro' => $livro], $this->getAutoresAssuntos()));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('livros.index')->with('error', 'Livro não encontrado.');
        }
    }

    /**
     * Atualiza um livro existente.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $this->validar($request);

            $livro = Livro::findOrFail($id);
            $livro->update($this->livroFields($request));
            $livro->autores()->sync($request->autores);
            $livro->assuntos()->sync($request->assuntos);

            return redirect()->route('livros.index')->with('success', 'Livro atualizado com sucesso!');
        } catch (LivroException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        } catch (ValidationException $e) {
            throw $e; // Deixa o Laravel lidar e preencher a session com os erros!
        } catch (ModelNotFoundException $e) {
            return redirect()->route('livros.index')->with('error', 'Livro não encontrado.');
        } catch (QueryException $e) {
            Log::error('Erro de banco ao atualizar livro', ['erro' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Erro ao atualizar livro. Tente novamente.');
        } catch (\Exception $e) {
            Log::critical('Erro inesperado ao atualizar livro', ['erro' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Erro inesperado. Tente novamente.');
        }
    }

    /**
     * Remove um livro do sistema.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $livro = Livro::findOrFail($id);
            $livro->delete();
            return redirect()->route('livros.index')->with('success', 'Livro removido!');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('livros.index')->with('error', 'Livro não encontrado.');
        } catch (QueryException $e) {
            Log::error('Erro de banco ao excluir livro', ['erro' => $e->getMessage()]);
            return redirect()->route('livros.index')->with('error', 'Erro ao excluir livro. Tente novamente.');
        } catch (\Exception $e) {
            Log::critical('Erro inesperado ao excluir livro', ['erro' => $e->getMessage()]);
            return redirect()->route('livros.index')->with('error', 'Erro inesperado. Tente novamente.');
        }
    }
}
