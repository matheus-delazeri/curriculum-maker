<div>
    <form wire:submit.prevent="save" class="bg-white dark:bg-gray-800 rounded-lg space-y-6">

        @if($curriculum->status === \App\Enums\CurriculumStatus::PENDING_REVIEW)
            <div class="flex gap-2 justify-end mb-6">
                <x-secondary-button id="toastui-save" type="submit">{{ __('Save') }}</x-secondary-button>
                <x-primary-button id="toastui-save" type="button"
                                  x-on:click.prevent="$dispatch('open-modal', 'confirm-finished')">{{ __('Finish Review') }}</x-primary-button>
            </div>
        @endif

        <div class="flex flex-col space-y-2">
            <input id="toastui-content" type="text" class="hidden" name="content" wire:model="content"
                   value="{{ $content }}">
            <div id="toastui-editor" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
        </div>
    </form>
    <x-modal name="confirm-finished" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="finish" class="p-6">

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Are you sure you want to finish this review?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('After finished you will not be able to make more changes to the content.') }}
            </p>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    {{ __('Finish Review') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</div>
