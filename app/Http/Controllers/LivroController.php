<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use App\Models\Autor;
use App\Models\Assunto;
use Illuminate\Http\Request;

class LivroController extends Controller
{
    public function index()
    {
        // Se estiver usando PowerGrid, talvez nem precise desse paginate.
        $livros = Livro::with(['autores', 'assuntos'])->paginate(10);
        return view('livraria.livros.index', compact('livros'));
    }

    public function create()
    {
        $autores = Autor::all();
        $assuntos = Assunto::all();
        return view('livraria.livros.create', compact('autores', 'assuntos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo'          => 'required|string|max:40',
            'editora'         => 'required|string|max:40',
            'edicao'          => 'required|integer|min:1',
            'ano_publicacao'  => 'required|digits:4|integer|between:1500,' . (date('Y')-1),
            'valor'           => ['required', 'regex:/^\d{1,3}(\.\d{3})*,\d{2}$/'],
            'autores'         => 'required|array|min:1',
            'assuntos'        => 'required|array|min:1',
        ]);

        // Converte valor brasileiro para float antes de salvar
        $valorBR = $request->input('valor'); // ex: 1.234,56
        $valorFloat = floatval(str_replace(',', '.', str_replace('.', '', $valorBR))); // 1234.56

        $data = $request->except(['valor', 'autores', 'assuntos']) + ['valor' => $valorFloat];

        $livro = Livro::create($data);
        $livro->autores()->sync($request->autores);
        $livro->assuntos()->sync($request->assuntos);

        return redirect()->route('livros.index')->with('success', 'Livro cadastrado!');
    }

    public function edit(Livro $livro)
    {
        $autores = Autor::all();
        $assuntos = Assunto::all();
        $livro->load('autores', 'assuntos');
        return view('livraria.livros.edit', compact('livro', 'autores', 'assuntos'));
    }

    public function update(Request $request, Livro $livro)
    {
        $request->validate([
            'titulo'          => 'required|string|max:40',
            'editora'         => 'required|string|max:40',
            'edicao'          => 'required|integer|min:1',
            'ano_publicacao'  => 'required|digits:4|integer|between:1500,' . (date('Y')-1),
            'valor'           => ['required', 'regex:/^\d{1,3}(\.\d{3})*,\d{2}$/'],
            'autores'         => 'required|array|min:1',
            'assuntos'        => 'required|array|min:1',
        ]);

        $valorBR = $request->input('valor');
        $valorFloat = floatval(str_replace(',', '.', str_replace('.', '', $valorBR)));

        $data = $request->except(['valor', 'autores', 'assuntos']) + ['valor' => $valorFloat];

        $livro->update($data);
        $livro->autores()->sync($request->autores);
        $livro->assuntos()->sync($request->assuntos);

        return redirect()->route('livros.index')->with('success', 'Livro atualizado com sucesso!');
    }

    public function destroy(Livro $livro)
    {
        $livro->delete();
        return redirect()->route('livros.index')->with('success', 'Livro removido!');
    }
}
