<?php

namespace App\Livewire;

use App\Enums\CurriculumStatus;
use App\Models\Curriculum;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;
use Spatie\LaravelPdf\Facades\Pdf;

class CurriculumResult extends Component
{

    public Curriculum $curriculum;
    public $content = "";

    public function mount(int $curriculumId)
    {
        $curriculum = Curriculum::findOrFail($curriculumId);
        $this->curriculum = $curriculum;
        $this->content = $curriculum->getContent();
    }

    public function render(): View
    {
        return view('livewire.curriculum.result');
    }

    public function reject()
    {
        $this->curriculum->status = CurriculumStatus::REJECTED;
        $this->curriculum->save();

        session()->flash('success-message', 'Curriculum rejected.');
        return redirect()->route('curriculum.grid');
    }

    public function approve()
    {
        $this->curriculum->status = CurriculumStatus::APPROVED;
        $this->curriculum->save();

        session()->flash('success-message', 'Curriculum approved!');
        return redirect()->route('curriculum.view', $this->curriculum->id);
    }

    public function pdf()
    {
        return redirect()->route('curriculum.pdf', $this->curriculum);
    }

}
