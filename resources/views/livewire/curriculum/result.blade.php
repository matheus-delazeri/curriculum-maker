<div>
    <div class="flex gap-2 justify-end mb-6">
        @if($curriculum->status === \App\Enums\CurriculumStatus::PENDING_APPROVAL && $curriculum->customer_id === Auth::user()->id)
            <x-primary-button type="button" wire:click="approve">{{ __('Approve') }}</x-primary-button>
            <x-danger-button type="button"
                             x-on:click.prevent="$dispatch('open-modal', 'confirm-reject')">{{ __('Reject') }}</x-danger-button>
        @elseif($curriculum->status === \App\Enums\CurriculumStatus::APPROVED)
            <x-primary-button type="button" wire:click="pdf">{{ __('View PDF') }}</x-primary-button>
        @endif
    </div>

    <div class="border p-2 bg-gray-100 text-black">
        {!! $content !!}
    </div>
    <x-modal name="confirm-reject" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="reject" class="p-6">

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Are you sure you want to reject this curriculum?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('If this curriculum is rejected you will not be able to download it.') }}
            </p>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Reject Curriculum') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</div>
