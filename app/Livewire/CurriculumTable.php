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
use PowerComponents\LivewirePowerGrid\Header;
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
    public bool $needJoin = false;

    /**
     * When set to true will render only curriculums
     * that the current user joined to edit.
     *
     * @var bool
     */
    public bool $toEdit = false;

    public function setUp(): array
    {
        return [
            Header::make()->includeViewOnTop('livewire.curriculum.grid.header'),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        if ($this->needJoin) {
            return Curriculum::query()
                ->whereIn('status', [CurriculumStatus::NEW, CurriculumStatus::ASSEMBLED])
                ->where('customer_id', '!=', Auth::id());
        }

        if ($this->toEdit) {
            return Curriculum::query()
                ->where('assembler_id', Auth::id())
                ->orWhere('reviewer_id', Auth::id());
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
            ->add('status_label', fn($curriculum) => $curriculum->status->label());
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

            Column::make(__('Status'), 'status_label')
                ->contentClasses([
                    CurriculumStatus::NEW->label() => 'text-orange-400',
                    CurriculumStatus::PENDING_ASSEMBLY->label() => 'text-blue-400',
                    CurriculumStatus::ASSEMBLED->label() => 'text-blue-400',
                    CurriculumStatus::PENDING_REVIEW->label() => 'text-blue-400',
                    CurriculumStatus::REVIEWED->label() => 'text-blue-400',
                    CurriculumStatus::PENDING_APPROVAL->label() => 'text-blue-400',
                    CurriculumStatus::APPROVED->label() => 'text-green-400',
                    CurriculumStatus::REJECTED->label() => 'text-red-400'
                ]),
            Column::action(__('Action'))
        ];
    }

    public function filters(): array
    {
        return [];
    }

    #[\Livewire\Attributes\On('view')]
    public function view($rowId): void
    {
        $this->redirectRoute('curriculum.view', $rowId);
    }

    #[\Livewire\Attributes\On('new')]
    public function new(): void
    {
        $this->redirectRoute('curriculum.new');
    }

    #[\Livewire\Attributes\On('join')]
    public function join($rowId): void
    {
        $this->redirectRoute('curriculum.join', $rowId);
    }

    public function actions(Curriculum $row): array
    {
        if ($this->needJoin) {
            return [
                Button::add('join')
                    ->slot(__('Join'))
                    ->id()
                    ->class('inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150')
                    ->dispatch('join', ['rowId' => $row->id])
            ];
        }

        return [
            Button::add('view')
                ->slot(__('View'))
                ->id()
                ->class('inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150')
                ->dispatch('view', ['rowId' => $row->id])
        ];
    }
}
