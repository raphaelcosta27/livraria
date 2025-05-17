<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Components\SetUp\Exportable;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

class RelatorioViewTable extends PowerGridComponent
{
    use WithExport;

    public string $tableName = 'view-livros-autores-table';
    public bool $showFilters = true;

    public function setUp(): array
    {
        return [
            PowerGrid::exportable('export-view-livros-autores-table')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            PowerGrid::header()
                // ->showToggleColumns()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource()
    {
        // Puxa dados da view criada
        return DB::table('vw_relatorio_livros');
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('nome_autor')
            ->add('livro_id')
            ->add('titulo_livro')
            ->add('editora')
            ->add('edicao')
            ->add('ano_publicacao')
            ->add('valor', fn($livro) => 'R$ ' . number_format($livro->valor, 2, ',', '.')) // Formata como moeda
            ->add('assuntos'); // Já vem concatenado na view
    }


    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->visibleInExport(visible: true)
                ->sortable()
                ->searchable(),
            
            Column::make('Autor', 'nome_autor')
                ->visibleInExport(visible: true)
                ->sortable()
                ->searchable(),

            Column::make('Título', 'titulo_livro')
                ->visibleInExport(visible: true)
                ->sortable()
                ->searchable(),

            Column::make('Editora', 'editora')
                ->visibleInExport(visible: true)
                ->sortable()
                ->searchable(),

            Column::make('Edição', 'edicao')
                ->visibleInExport(visible: true)
                ->sortable()
                ->searchable(),

            Column::make('Ano de Publicação', 'ano_publicacao')
                ->visibleInExport(visible: true)
                ->sortable()
                ->searchable(),

            Column::make('Valor', 'valor')
                ->visibleInExport(visible: true)
                ->sortable(),

            Column::make('Assuntos', 'assuntos')
                ->visibleInExport(visible: true)
                ->searchable(),
        ];
    }
}
