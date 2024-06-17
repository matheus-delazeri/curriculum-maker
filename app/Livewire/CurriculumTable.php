<?php

namespace App\Livewire;

use App\Enums\CurriculumStatus;
use App\Models\Curriculum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class CurriculumTable extends PowerGridComponent
{
    use WithExport;

    /**
     * When set to true will render the curriculums
     * available to assembly/review.
     *
     * @var bool
     */
    public bool $availableToMount = false;

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
        if ($this->availableToMount) {
            return Curriculum::query()
                ->whereIn('status', [CurriculumStatus::NEW, CurriculumStatus::PENDING_REVIEW])
                ->where('customer_id', '!=', Auth::id());
        }

        return Curriculum::where('customer_id', Auth::id());
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
            Column::make('Id', 'id')->sortable(),
            Column::make(__('Assembler'), 'assembler'),
            Column::make(__('Reviewer'), 'reviewer'),
            Column::make(__('Created at'), 'created_at', 'created_at')
                ->sortable(),
            Column::make(__('Updated at'), 'updated_at', 'updated_at')
                ->sortable(),

            Column::make(__('Status'), 'status')
                ->contentClasses([
                    CurriculumStatus::NEW->value => 'text-orange-400',
                    CurriculumStatus::PENDING_ASSEMBLY->value => 'text-blue-400',
                    CurriculumStatus::PENDING_REVIEW->value => 'text-blue-400',
                    CurriculumStatus::PENDING_APPROVAL->value => 'text-blue-400',
                    CurriculumStatus::APPROVED->value => 'text-green-400',
                    CurriculumStatus::REJECTED->value => 'text-red-400'
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

    #[\Livewire\Attributes\On('view')]
    public function view($rowId): void
    {
        $this->redirectRoute('curriculum.view', $rowId);
    }

    public function actions(Curriculum $row): array
    {
        return [
            Button::add('view')
                ->slot(__('View'))
                ->id()
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('view', ['rowId' => $row->id])
        ];
    }
}
