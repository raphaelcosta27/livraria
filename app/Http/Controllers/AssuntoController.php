<?php 

namespace App\Http\Controllers;

use App\Models\Assunto;
use Illuminate\Http\Request;

class AssuntoController extends Controller
{
    public function index()
    {
        $assuntos = Assunto::orderBy('id', 'desc')->paginate(10);
        return view('livraria.assuntos.index', compact('assuntos'));
    }

    public function create()
    {
        return view('livraria.assuntos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required|string|max:255'
        ]);

        Assunto::create($request->only('descricao'));

        return redirect()->route('assuntos.index')
            ->with('success', 'Assunto criado com sucesso!');
    }

    public function edit(Assunto $assunto)
    {
        return view('livraria.assuntos.edit', compact('assunto'));
    }

    public function update(Request $request, Assunto $assunto)
    {
        $request->validate([
            'descricao' => 'required|string|max:255'
        ]);

        $assunto->update($request->only('descricao'));

        return redirect()->route('assuntos.index')
            ->with('success', 'Assunto atualizado com sucesso!');
    }

    public function destroy(Assunto $assunto)
    {
        $assunto->delete();

        return redirect()->route('assuntos.index')
            ->with('success', 'Assunto removido com sucesso!');
    }
}
