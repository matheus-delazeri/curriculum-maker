<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Livewire\Volt\Component;

new class extends Component {
    public string $theme = '';
    public string $locale = '';
    public array $availableLocales = [];

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $preferences = Auth::user()->preferences;
        $this->theme = $preferences['theme'] ?? 'light';
        $this->locale = $preferences['locale'] ?? Config::get('app.locale');

        $this->availableLocales = $this->getAvailableLocales();
    }

    /**
     * Get available locales from the "lang" folder.
     */
    private function getAvailableLocales(): array
    {
        $locales = [];
        $langPath = base_path('lang');

        if (File::exists($langPath)) {
            $files = File::files($langPath);
            foreach ($files as $file) {
                if ($file->getExtension() === 'json') {
                    $locales[] = $file->getFilenameWithoutExtension();
                }
            }
        }

        return $locales;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updatePreferences(): void
    {
        $user = Auth::user();
        $preferences = ['theme' => $this->theme, 'locale' => $this->locale];

        $user->fill(['preferences' => $preferences]);
        $user->save();

        $this->redirectRoute('profile');
    }

}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Preferences') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's preferences.") }}
        </p>
    </header>

    <form wire:submit="updatePreferences" class="mt-6 space-y-6">
        <div>
            <x-input-label for="theme" :value="__('Theme')"/>
            <x-select wire:model="theme" id="theme" name="theme" class="mt-1 block w-full">
                <option value="dark">{{ __('Dark') }}</option>
                <option value="light">{{ __('Light') }} </option>
            </x-select>
            <x-input-error class="mt-2" :messages="$errors->get('theme')"/>
        </div>
        <div>
            <x-input-label for="locale" :value="__('Locale')"/>
            <x-select wire:model="locale" id="locale" name="locale" class="mt-1 block w-full">
                @foreach ($availableLocales as $locale)
                    <option value="{{ $locale }}">{{ $locale }}</option>
                @endforeach
            </x-select>
            <x-input-error class="mt-2" :messages="$errors->get('locale')"/>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            <x-action-message class="me-3" on="profile-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>
