<?php

namespace App\Livewire;

use App\Models\Curriculum;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CurriculumResult extends Component
{

    public Curriculum $curriculum;
    public $content = "";

    public function mount(int $curriculumId)
    {
        $curriculum = Curriculum::findOrFail($curriculumId);
        $this->curriculum = $curriculum;
        if ($curriculum->versions()->count()) {
            $this->content = $curriculum->versions()->latest()->first()->content;
        }
    }

    public function render()
    {
        $isOwner = $this->curriculum->customer_id === Auth::id();
        $this->content = $this->replaceVariables($this->content, $isOwner);
        return view('livewire.curriculum.result');
    }

    private function replaceVariables(string $content, bool $isOwner): string
    {
        $customerInfo = $this->curriculum->customer_info;

        return preg_replace_callback('/\{([^}]+)\}/', function ($matches) use ($customerInfo, $isOwner) {
            $variableName = $matches[1];

            $keys = explode('.', $variableName);

            $type = $keys[0] ?? null;

            if ($type === 'customer') {
                $attribute = $keys[1] ?? null;
                if (isset($customerInfo[$attribute])) {
                    $value = $customerInfo[$attribute];
                } else {
                    return $matches[0];
                }
            } elseif ($type === 'experiences' || $type === 'educations') {
                $index = $keys[1] ?? null;
                $attribute = $keys[2] ?? null;

                if (is_numeric($index) && isset($customerInfo[$type][$index][$attribute])) {
                    $value = $customerInfo[$type][$index][$attribute];
                } else {
                    return $matches[0];
                }
            } else {
                return $matches[0];
            }

            if (!$isOwner) {
                $value = str_repeat('*', strlen($value));
            }

            return $value;
        }, $content);
    }

}
