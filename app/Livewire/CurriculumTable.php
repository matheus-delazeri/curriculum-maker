<?php

namespace App\Livewire;

use App\Enums\CurriculumStatus;
use App\Models\Curriculum;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
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

final class CurriculumTable extends PowerGridComponent
{
    use WithExport;

    public function setUp(): array
    {
        return [
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Curriculum::where('id', Auth::id());
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
            ->add('assembler', function ($curriculum) {
                return !is_null($curriculum->assembler) ? $curriculum->assembler->name : '-';
            })
            ->add('reviewer', function ($curriculum) {
                return !is_null($curriculum->reviewer) ? $curriculum->reviewer->name : '-';
            })
            ->add('status', function ($curriculum) {
                return $curriculum->status;
            });
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make(__('Assembler'), 'assembler'),
            Column::make(__('Reviewer'), 'reviewer'),
            Column::make(__('Created at'), 'created_at', 'created_at')
                ->sortable(),

            Column::make(__('Status'), 'status')
                ->contentClasses([
                    CurriculumStatus::NEW->value => 'text-orange-400',
                    CurriculumStatus::PENDING_ASSEMBLY->value => 'text-blue-400',
                    CurriculumStatus::PENDING_REVIEW->value => 'text-blue-400',
                    CurriculumStatus::PENDING_APPROVAL->value => 'text-blue-400',
                    CurriculumStatus::APPROVED->value => 'text-green-400',
                    CurriculumStatus::REJECTED->value => 'text-red-400',
                    'out-of-stock' => 'text-red-600'
                ]),
            Column::action(__('Action'))
        ];
    }

    public function filters(): array
    {
        return [
            Filter::enumSelect('status', 'status')
                ->dataSource(CurriculumStatus::cases())
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->redirectRoute('curriculum.edit', $rowId);
    }

    public function actions(Curriculum $row): array
    {
        return [
            Button::add('edit')
                ->slot('Edit')
                ->id()
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('edit', ['rowId' => $row->id])
        ];
    }
}
