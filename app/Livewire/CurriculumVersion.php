<?php

namespace App\Livewire;

use App\Models\Curriculum\Version;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class CurriculumVersion extends PowerGridComponent
{
    use WithExport;

    public string $sortField = 'id';
    public string $sortDirection = 'desc';

    public function setUp(): array
    {
        return [
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Version::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('created_at')
            ->add('updated_at')
            ->add('editor', function ($version) {
                return !is_null($version->editor) ? $version->editor->name : '-';
            });

    }

    public function columns(): array
    {
        return [
            Column::make(__('Id'), 'id')->sortable(),
            Column::make(__('Editor'), 'editor'),
            Column::make(__('Created at'), 'created_at', 'created_at')
                ->sortable(),
            Column::make(__('Updated at'), 'updated_at', 'updated_at')
                ->sortable(),
            Column::action(__('Action'))
        ];
    }

    public function filters(): array
    {
        return [
        ];
    }

    #[\Livewire\Attributes\On('restore')]
    public function restore($curriculumId, $versionId): void
    {
        $this->redirectRoute('curriculum.view.version', ['curriculumId' => $curriculumId, 'versionId' => $versionId]);
    }

    public function actions(Version $version): array
    {
        return [
            Button::add('restore')
                ->slot(__('Restore'))
                ->id()
                ->class('inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150')
                ->dispatch('restore', ['curriculumId' => $version->curriculum->id ,'versionId' => $version->id])
        ];
    }
}
