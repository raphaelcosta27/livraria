<?php

namespace App\Livewire;

use App\Models\Autor;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class AutoresTable extends PowerGridComponent
{
    public string $tableName = 'autores-table';
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
        return Autor::query();
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('nome')
            ;
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('Nome', 'nome')
                ->sortable()
                ->searchable(),

            Column::action('Ações'),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('nome', 'Nome'),
        ];
    }

    public function actions($row): array
    {
        return [
            Button::add('edit')
                ->slot('
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline-block mr-1 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13l6-6m2 2L9 13l-4 4V17h2l4-4z" />
                    </svg>
                    Editar
                ')
                ->route('autores.edit', ['autore' => $row->id])
                ->class('text-yellow-700 hover:text-yellow-900 hover:bg-yellow-50 rounded px-2 py-1'),

            Button::add('delete')
                ->slot('
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline-block mr-1 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6h18M9 6v12a2 2 0 002 2h2a2 2 0 002-2V6M10 11h4" />
                    </svg>
                    Excluir
                ')
                ->class('text-red-700 hover:text-red-900 hover:bg-red-50 rounded px-2 py-1')
                ->attributes([
                    'onclick' => "confirmarExclusaoAutor('{$row->id}', '".htmlspecialchars(addslashes($row->nome))."'); return false;",
                    'title' => 'Excluir',
                ]),
        ];
    }

    // Você pode implementar rules e outras features conforme necessidade.
}
