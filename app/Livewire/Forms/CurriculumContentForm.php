<?php

namespace App\Livewire\Forms;

use App\Models\Curriculum;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CurriculumContentForm extends Component
{
    public Curriculum|null $curriculum = null;
    public $value = '';
    public $trixId;

    public function mount(int $curriculumId, int $versionId = null)
    {
        $this->curriculum = Curriculum::findOrFail($curriculumId);
        $this->trixId = 'trix-' . uniqid();
        if (is_null($versionId) && $this->curriculum->versions()->count()) {
            $versionId = $this->curriculum->versions()->latest()->first()->id;
        }

        if (!is_null($versionId)) {
            $version = Curriculum\Version::findOrFail($versionId);
            $this->value = $version->content;
        }
    }

    public function render()
    {
        return view('livewire.curriculum.content');
    }

    public function updatedValue($value){
        $this->value = $value;
    }

    public function save()
    {
        $version = Curriculum\Version::create([
            'content' => $this->value,
            'curriculum_id' => $this->curriculum->id,
            'editor_id' => Auth::id()
        ]);

        session()->flash('success-message', 'Curriculum version saved successfully.');
        return redirect()->route('curriculum.view', $version->curriculum->id);
    }
}
