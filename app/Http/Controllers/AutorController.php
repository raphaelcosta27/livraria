<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AutorController extends Controller
{
    /**
     * Exibe a listagem de autores.
     */
    public function index(): View
    {
        $autores = Autor::orderByDesc('id')->paginate(10);

        return view('livraria.autores.index', compact('autores'));
    }

    /**
     * Exibe o formulário de criação de um novo autor.
     */
    public function create(): View
    {
        return view('livraria.autores.create');
    }

    /**
     * Armazena um novo autor no banco de dados.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
        ]);

        Autor::create($validated);

        return redirect()
            ->route('autores.index')
            ->with('success', 'Autor criado com sucesso!');
    }

    /**
     * Exibe o formulário de edição de um autor existente.
     */
    public function edit(Autor $autor): View
    {
        return view('livraria.autores.edit', compact('autor'));
    }

    /**
     * Atualiza os dados de um autor no banco de dados.
     */
    public function update(Request $request, Autor $autor): RedirectResponse
    {
        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
        ]);

        $autor->update($validated);

        return redirect()
            ->route('autores.index')
            ->with('success', 'Autor atualizado com sucesso!');
    }

    /**
     * Remove um autor do banco de dados, caso não esteja vinculado a livros.
     */
    public function destroy(Autor $autor): RedirectResponse
    {
        if ($autor->livros()->exists()) {
            return redirect()
                ->route('autores.index')
                ->with('error', 'Este autor não pode ser excluído, pois está vinculado a um ou mais livros.');
        }

        $autor->delete();

        return redirect()
            ->route('autores.index')
            ->with('success', 'Autor removido com sucesso!');
    }
}
