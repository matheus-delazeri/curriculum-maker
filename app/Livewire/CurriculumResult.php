<?php

namespace App\Livewire;

use App\Models\Curriculum;
use Livewire\Component;

class CurriculumResult extends Component
{

    public $content = "";

    public function mount(int $curriculumId)
    {
        $curriculum = Curriculum::findOrFail($curriculumId);
        if ($curriculum->versions()->count()) {
            $this->content = $curriculum->versions()->latest()->first()->content;
        }
    }

    public function render()
    {
        return view('livewire.curriculum.result');
    }
}
