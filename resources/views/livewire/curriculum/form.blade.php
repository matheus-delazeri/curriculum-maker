<div class="text-gray-900 dark:text-gray-100">
    <form wire:submit.prevent="save" class="bg-white dark:bg-gray-800 rounded-lg space-y-6">

        <div class="flex gap-2 justify-end mb-6">
            <x-secondary-button type="button" class="flex gap-2" wire:click="back">
                <svg class="w-4 h-4 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18"/>
                </svg>
                {{ __('Back') }}
            </x-secondary-button>
            @if(is_null($curriculumId))
                <x-primary-button type="submit">{{ __('Save') }}</x-primary-button>
            @endif
        </div>

        <div class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="mb-4">
                    <x-input-label :value="__('Name')"/>
                    <x-text-input :disabled="$curriculumId" class="w-full" type="text" wire:model="name" id="name"/>
                    <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                    @if($curriculumId && $curriculum->customer->id != Auth::id())
                        <small class="block text-gray-500 mt-1">Var: <span class="text-gray-700 dark:text-white">{customer.name}</span></small>
                    @endif
                </div>
                <div class="mb-4">
                    <x-input-label :value="__('E-mail')"/>
                    <x-text-input :disabled="$curriculumId" class="w-full" type="text" wire:model="email" id="email"/>
                    <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                    @if($curriculumId && $curriculum->customer->id != Auth::id())
                        <small class="block text-gray-500 mt-1">Var: <span class="text-gray-700 dark:text-white">{customer.email}</span></small>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="mb-4">
                    <x-input-label for="address" :value="__('Phone')"/>
                    <x-text-input :disabled="$curriculumId" class="w-full" type="text" wire:model="phone" id="phone"/>
                    <x-input-error :messages="$errors->get('phone')" class="mt-2"/>
                    @if($curriculumId && $curriculum->customer->id != Auth::id())
                        <small class="block text-gray-500 mt-1">Var: <span class="text-gray-700 dark:text-white">{customer.phone}</span></small>
                    @endif
                </div>
                <div class="mb-4">
                    <x-input-label for="address" :value="__('Address')"/>
                    <x-text-input :disabled="$curriculumId" class="w-full" type="text" wire:model="address" id="address"/>
                    <x-input-error :messages="$errors->get('address')" class="mt-2"/>
                    @if($curriculumId && $curriculum->customer->id != Auth::id())
                        <small class="block text-gray-500 mt-1">Var: <span class="text-gray-700 dark:text-white">{customer.address}</span></small>
                    @endif
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <h2 class="text-lg font-semibold">{{ __('Education') }}</h2>
            @foreach($educations as $index => $education)
                <div class="border border-gray-200 rounded p-4">
                    <div class="grid md:grid-cols-3 gap-4">
                        <div class="mb-4">
                            <x-input-label for="institution{{ $index }}" :value="__('Institution')"/>
                            <x-text-input :disabled="$curriculumId" class="w-3/4" type="text" wire:model="educations.{{ $index }}.institution" id="institution{{ $index }}"/>
                            <x-input-error :messages="$errors->get('educations.'.$index.'.institution')" class="mt-2"/>
                            @if($curriculumId && $curriculum->customer->id != Auth::id())
                                <small class="block text-gray-500 mt-1">Var: <span class="text-gray-700 dark:text-white">{educations.{{ $index }}.institution}</span></small>
                            @endif
                        </div>
                        <div class="mb-4">
                            <x-input-label for="start_date_education{{ $index }}" :value="__('Start Date')"/>
                            <x-text-input :disabled="$curriculumId" type="date" wire:model="educations.{{ $index }}.start_date" id="start_date_education{{ $index }}"/>
                            <x-input-error :messages="$errors->get('educations.'.$index.'.start_date')" class="mt-2"/>
                            @if($curriculumId && $curriculum->customer->id != Auth::id())
                                <small class="block text-gray-500 mt-1">Var: <span class="text-gray-700 dark:text-white">{educations.{{ $index }}.start_date}</span></small>
                            @endif
                        </div>
                        <div class="mb-4">
                            <x-input-label for="end_date_education{{ $index }}" :value="__('End Date')"/>
                            <x-text-input :disabled="$curriculumId" type="date" wire:model="educations.{{ $index }}.end_date" id="end_date_education{{ $index }}"/>
                            <x-input-error :messages="$errors->get('educations.'.$index.'.end_date')" class="mt-2"/>
                            @if($curriculumId && $curriculum->customer->id != Auth::id())
                                <small class="block text-gray-500 mt-1">Var: <span class="text-gray-700 dark:text-white">{educations.{{ $index }}.end_date}</span></small>
                            @endif
                        </div>
                    </div>
                    <div class="mb-4">
                        <x-input-label for="description_education{{ $index }}" :value="__('Description')"/>
                        <textarea wire:model="educations.{{ $index }}.description" @disabled(!is_null($curriculumId)) id="description_education{{ $index }}"
                                  class="form-textarea border-gray-300 rounded-md shadow-sm mt-1 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" rows="3"></textarea>
                        <x-input-error :messages="$errors->get('educations.'.$index.'.description')" class="mt-2"/>
                        @if($curriculumId && $curriculum->customer->id != Auth::id())
                            <small class="block text-gray-500 mt-1">Var: <span class="text-gray-700 dark:text-white">{educations.{{ $index }}.description}</span></small>
                        @endif
                    </div>
                    @if(is_null($curriculumId))
                        <div class="flex items-end">
                            <x-danger-button type="button" wire:click="removeEducation({{ $index }})">
                                {{ __('Remove') }}
                            </x-danger-button>
                        </div>
                    @endif
                </div>
            @endforeach
            @if(is_null($curriculumId))
                <div>
                    <x-primary-button type="button" wire:click="addEducation">
                        {{ __('Add Education') }}
                    </x-primary-button>
                </div>
            @endif
        </div>

        <div class="space-y-4">
            <h2 class="text-lg font-semibold">{{__("Experience") }}</h2>
            @foreach($experiences as $index => $experience)
                <div class="border border-gray-200 rounded p-4">
                    <div class="grid gap-4 md:grid-cols-3">
                        <div class="mb-4">
                            <x-input-label for="company{{ $index }}" :value="__('Company')"/>
                            <x-text-input :disabled="$curriculumId" type="text" class="w-3/4" wire:model="experiences.{{ $index }}.company" id="company{{ $index }}"/>
                            <x-input-error :messages="$errors->get('experiences.'.$index.'.company')" class="mt-2"/>
                            @if($curriculumId && $curriculum->customer->id != Auth::id())
                                <small class="block text-gray-500 mt-1">Var: <span class="text-gray-700 dark:text-white">{experiences.{{ $index }}.company}</span></small>
                            @endif
                        </div>
                        <div class="mb-4">
                            <x-input-label for="start_date_experience{{ $index }}" :value="__('Start Date')"/>
                            <x-text-input :disabled="$curriculumId" type="date" wire:model="experiences.{{ $index }}.start_date" id="start_date_experience{{ $index }}"/>
                            <x-input-error :messages="$errors->get('experiences.'.$index.'.start_date')" class="mt-2"/>
                            @if($curriculumId && $curriculum->customer->id != Auth::id())
                                <small class="block text-gray-500 mt-1">Var: <span class="text-gray-700 dark:text-white">{experiences.{{ $index }}.start_date}</span></small>
                            @endif
                        </div>
                        <div class="mb-4">
                            <x-input-label for="end_date_experience{{ $index }}" :value="__('End Date')"/>
                            <x-text-input :disabled="$curriculumId" type="date" wire:model="experiences.{{ $index }}.end_date" id="end_date_experience{{ $index }}"/>
                            <x-input-error :messages="$errors->get('experiences.'.$index.'.end_date')" class="mt-2"/>
                            @if($curriculumId && $curriculum->customer->id != Auth::id())
                                <small class="block text-gray-500 mt-1">Var: <span class="text-gray-700 dark:text-white">{experiences.{{ $index }}.end_date}</span></small>
                            @endif
                        </div>
                    </div>
                    <div class="mb-4">
                        <x-input-label for="description_experience{{ $index }}" :value="__('Description')"/>
                        <textarea wire:model="experiences.{{ $index }}.description" @disabled(!is_null($curriculumId)) id="description_experience{{ $index }}"
                                  class="form-textarea border-gray-300 rounded-md shadow-sm mt-1 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" rows="3"></textarea>
                        <x-input-error :messages="$errors->get('experiences.'.$index.'.description')" class="mt-2"/>
                        @if($curriculumId && $curriculum->customer->id != Auth::id())
                            <small class="block text-gray-500 mt-1">Var: <span class="text-gray-700 dark:text-white">{experiences.{{ $index }}.description}</span></small>
                        @endif
                    </div>
                    @if(is_null($curriculumId))
                        <div class="flex items-end">
                            <x-danger-button type="button" wire:click="removeExperience({{ $index }})">
                                {{ __('Remove') }}
                            </x-danger-button>
                        </div>
                    @endif
                </div>
            @endforeach
            @if(is_null($curriculumId))
                <div>
                    <x-primary-button type="button" wire:click="addExperience">
                        {{ __('Add Experience') }}
                    </x-primary-button>
                </div>
            @endif
        </div>
    </form>
</div>
