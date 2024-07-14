<?php

namespace App\Livewire\Forms;

use App\Enums\CurriculumStatus;
use App\Models\Curriculum;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CurriculumForm extends Component
{
    public ?int $curriculumId = null;
    public Curriculum $curriculum;
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $address = '';
    public array $educations = [];
    public array $experiences = [];

    protected array $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
        'phone' => 'required|string|max:20',
        'address' => 'required|string|max:255',
        'educations.*.institution' => 'required|string',
        'educations.*.description' => 'nullable|string',
        'educations.*.start_date' => 'required|date',
        'educations.*.end_date' => 'required|date|after_or_equal:educations.*.start_date',
        'experiences.*.company' => 'required|string',
        'experiences.*.description' => 'nullable|string',
        'experiences.*.start_date' => 'required|date',
        'experiences.*.end_date' => 'required|date|after_or_equal:experiences.*.start_date',
    ];

    public function mount($curriculumId = null)
    {
        if ($curriculumId) {
            $curriculum = Curriculum::findOrFail($curriculumId);
            $this->curriculum = $curriculum;
            $this->curriculumId = $curriculum->id;
            $this->mountCustomerData($curriculum);
        } else {
            $this->educations = [];
            $this->experiences = [];
        }
    }

    private function mountCustomerData(Curriculum $curriculum)
    {
        $customerInfo = $curriculum->customer_info;
        if ($curriculum->customer->id != Auth::id()) {
            $customerInfo = $this->maskCustomerInfo($customerInfo);
        }

        $this->name = $customerInfo['name'];
        $this->email = $customerInfo['email'];
        $this->phone = $customerInfo['phone'];
        $this->address = $customerInfo['address'];
        $this->educations = $customerInfo['educations'] ?? [];
        $this->experiences = $customerInfo['experiences'] ?? [];
    }

    private function maskCustomerInfo($info)
    {
        $maskedInfo = [];
        foreach ($info as $key => $value) {
            if (is_string($value)) {
                $maskedInfo[$key] = str_repeat('*', strlen($value));
            } else {
                $maskedInfo[$key] = $value;
            }
        }

        return $maskedInfo;
    }

    public function save()
    {
        $this->validate();

        $curriculum = Curriculum::updateOrCreate(['id' => $this->curriculumId], [
            'customer_info' => [
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'educations' => $this->educations,
                'experiences' => $this->experiences,
            ],
            'status' => CurriculumStatus::NEW,
            'customer_id' => Auth::id(),
        ]);

        session()->flash('success-message', 'Curriculum saved successfully.');
        return redirect()->route('curriculum.view', $curriculum->id);
    }

    public function addEducation()
    {
        $this->educations[] = [
            'institution' => '',
            'description' => '',
            'start_date' => '',
            'end_date' => '',
        ];
    }

    public function removeEducation($index)
    {
        unset($this->educations[$index]);
        $this->educations = array_values($this->educations);
    }

    public function addExperience()
    {
        $this->experiences[] = [
            'company' => '',
            'description' => '',
            'start_date' => '',
            'end_date' => '',
        ];
    }

    public function removeExperience($index)
    {
        unset($this->experiences[$index]);
        $this->experiences = array_values($this->experiences);
    }

    public function back(): void
    {
        $this->redirectRoute('dashboard');
    }

    public function render()
    {
        return view('livewire.curriculum.form');
    }
}
