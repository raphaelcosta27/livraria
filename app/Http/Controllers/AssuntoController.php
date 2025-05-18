<?php

namespace App\Http\Controllers;

use App\Models\Assunto;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AssuntoController extends Controller
{
    /**
     * Exibe a listagem de assuntos.
     *
     * @return View
     */
    public function index(): View
    {
        $assuntos = Assunto::orderByDesc('id')->paginate(10);

        return view('livraria.assuntos.index', compact('assuntos'));
    }

    /**
     * Exibe o formulário de criação de um novo assunto.
     *
     * @return View
     */
    public function create(): View
    {
        return view('livraria.assuntos.create');
    }

    /**
     * Armazena um novo assunto no banco de dados.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'descricao' => 'required|string|max:255',
        ]);

        Assunto::create($validated);

        return redirect()
            ->route('assuntos.index')
            ->with('success', 'Assunto criado com sucesso!');
    }

    /**
     * Exibe o formulário de edição de um assunto existente.
     *
     * @param  Assunto  $assunto
     * @return View
     */
    public function edit(Assunto $assunto): View
    {
        return view('livraria.assuntos.edit', compact('assunto'));
    }

    /**
     * Atualiza um assunto existente no banco de dados.
     *
     * @param  Request  $request
     * @param  Assunto  $assunto
     * @return RedirectResponse
     */
    public function update(Request $request, Assunto $assunto): RedirectResponse
    {
        $validated = $request->validate([
            'descricao' => 'required|string|max:255',
        ]);

        $assunto->update($validated);

        return redirect()
            ->route('assuntos.index')
            ->with('success', 'Assunto atualizado com sucesso!');
    }

    /**
     * Remove um assunto do banco de dados.
     *
     * @param  Assunto  $assunto
     * @return RedirectResponse
     */
    public function destroy(Assunto $assunto): RedirectResponse
    {
        $assunto->delete();

        return redirect()
            ->route('assuntos.index')
            ->with('success', 'Assunto removido com sucesso!');
    }
}
