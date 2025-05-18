<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use Illuminate\Http\Request;

class AutorController extends Controller
{
    public function index()
    {
        $autores = Autor::paginate(10);
        return view('livraria.autores.index', compact('autores'));
    }

    public function create()
    {
        return view('livraria.autores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        Autor::create($request->all());

        return redirect()->route('autores.index')->with('success', 'Autor criado com sucesso!');
    }

    public function edit(Autor $autore)
    {
        return view('livraria.autores.edit', compact('autore'));
    }

    public function update(Request $request, Autor $autore)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        $autore->update([
            'nome' => $request->input('nome'),
        ]);

        return redirect()->route('autores.index')->with('success', 'Autor atualizado com sucesso!');
    }

    public function destroy(Autor $autore)
    {
        if ($autore->livros()->count() > 0) {
            return redirect()->route('autores.index')
                ->with('error', 'Este autor não pode ser excluído, pois está vinculado a um ou mais livros.');
        }

        $autore->delete();

        return redirect()->route('autores.index')
            ->with('success', 'Autor removido com sucesso!');
    }

}
