<?php

namespace App\Livewire;

use App\Models\Livro;
use App\Models\Autor;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class LivrosTable extends PowerGridComponent
{
    public string $tableName = 'livros-table';
    public bool $showFilters = true;

    public function setUp(): array
    {
        $this->persist(['columns', 'filters', 'sorting'], prefix: auth()->id ?? '');

        return [
            PowerGrid::header()
                ->showToggleColumns()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Livro::query()->with(['autores', 'assuntos']);
    }

    public function relationSearch(): array
    {
        return [
            'autores' => ['id'],
            'assuntos' => ['id'],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('titulo')
            ->add('editora')
            ->add('edicao')
            ->add('ano_publicacao')
            ->add('valor', fn($livro) => 'R$ ' . number_format($livro->valor, 2, ',', '.')) // Aqui pode usar closure pois quer exibir formatado, mas NÃO para filtrar
            ->add('autores', fn($livro) => $livro->autores->pluck('nome')->implode(', '))
            ->add('assuntos', fn($livro) => $livro->assuntos->pluck('descricao')->implode(', '));
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('Titulo', 'titulo')
                ->sortable()
                ->searchable()
                ->headerAttribute('class', 'max-w-xs')
                ->bodyAttribute('class', 'max-w-xs truncate'),

            Column::make('Editora', 'editora')
                ->sortable()
                ->searchable(),

            Column::make('Edição', 'edicao')
                ->sortable()
                ->searchable(),

            Column::make('Ano', 'ano_publicacao')
                ->sortable()
                ->searchable(),

            Column::make('Valor', 'valor')
                ->sortable()
                ->bodyAttribute('class', 'text-right'),

            Column::make('Autores', 'autores')
                ->bodyAttribute('class', 'whitespace-normal'),

            Column::make('Assuntos', 'assuntos')
                ->bodyAttribute('class', 'whitespace-normal'),

            Column::action('Ações'),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('titulo'),
            Filter::inputText('editora'),
            Filter::number('edicao'),
            Filter::number('ano_publicacao'),
            // Filter::floar('valor'),
            Filter::multiSelect('autores_id')->dataSource(Autor::all())->optionValue('id')->optionLabel('nome'),
            // Você pode adicionar mais filtros se quiser
        ];
    }

    public function actions($row): array
    {
        return [
            Button::add('edit')
                ->slot('
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 inline-block mr-1 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13l6-6m2 2L9 13l-4 4V17h2l4-4z" />
                    </svg>
                    Editar
                ')
                ->route('livros.edit', ['livro' => $row->id])
                ->class('text-yellow-700 hover:text-yellow-900 hover:bg-yellow-50 rounded px-2 py-1'),

            Button::add('delete')
                ->slot('
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 inline-block mr-1 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6h18M9 6v12a2 2 0 002 2h2a2 2 0 002-2V6M10 11h4" />
                    </svg>
                    Excluir
                ')
                ->class('text-red-700 hover:text-red-900 hover:bg-red-50 rounded px-2 py-1')
                ->attributes([
                    // Chama função JS, passando id e título
                    'onclick' => "confirmarExclusaoLivro('{$row->id}', '".htmlspecialchars(addslashes($row->titulo))."'); return false;",
                    'title' => 'Excluir',
                ]),
        ];
    }

}
