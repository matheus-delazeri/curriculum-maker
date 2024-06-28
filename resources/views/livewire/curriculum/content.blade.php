<form wire:submit.prevent="save" class="bg-white dark:bg-gray-800 rounded-lg space-y-6">

    <div class="flex gap-2 justify-end mb-6">
        <x-primary-button id="toastui-save" type="submit">{{ __('Save') }}</x-primary-button>
    </div>

    <div class="flex flex-col space-y-2">
        <input id="toastui-content" type="text" class="hidden" name="content" wire:model="content" value="{{ $content }}">
        <div id="toastui-editor" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
    </div>
</form>
