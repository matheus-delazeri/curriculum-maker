<?php

namespace App\Livewire\Forms;

use App\Enums\CurriculumStatus;
use App\Models\Curriculum;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CurriculumContentForm extends Component
{
    public Curriculum|null $curriculum = null;
    public $content = '';

    public function mount(int $curriculumId, int $versionId = null)
    {
        $this->curriculum = Curriculum::findOrFail($curriculumId);
        if (is_null($versionId) && $this->curriculum->versions()->count()) {
            $versionId = $this->curriculum->versions()->latest()->first()->id;
        }

        if (!is_null($versionId)) {
            $version = Curriculum\Version::findOrFail($versionId);
            $this->content = $version->content;
        }
    }

    public function render()
    {
        return view('livewire.curriculum.content', [
            'content' => $this->content
        ]);
    }

    public function save()
    {
        if (empty($this->content)) {
            session()->flash('error-message', 'Unable to save curriculum version with empty content!');
            return redirect()->route('curriculum.view', $this->curriculum->id);
        }

        if ($this->curriculum->status !== CurriculumStatus::PENDING_REVIEW) {
            session()->flash('error-message', 'Unable to perform action in this curriculum!');
            return redirect()->route('curriculum.view', $this->curriculum->id);
        }

        Curriculum\Version::create([
            'content' => $this->content,
            'curriculum_id' => $this->curriculum->id,
            'editor_id' => Auth::id()
        ]);

        session()->flash('success-message', 'Curriculum version saved successfully.');
        return redirect()->route('curriculum.view', $this->curriculum->id);
    }

    public function finish()
    {
        $this->save();
        $this->curriculum->status = CurriculumStatus::PENDING_APPROVAL;
        $this->curriculum->save();

        session()->flash('success-message', 'Curriculum review finished!');
        return redirect()->route('curriculum.view', $this->curriculum->id);
    }
}
