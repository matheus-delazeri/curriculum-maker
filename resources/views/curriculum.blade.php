@if(!isset($curriculumId))
    {{ $curriculumId = null }}
@endif
@if(!isset($versionId))
    {{ $versionId = null }}
@endif

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Curriculum') }}
        </h2>
    </x-slot>

    <div class="py-6" x-data="{ activeTab: 'information' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex">
                <div class="w-1/4 bg-gray-50 dark:bg-gray-700 p-4">
                    <ul class="space-y-2 text-sm font-medium text-gray-500 dark:text-gray-400">
                        <li>
                            <button @click.prevent="activeTab = 'information'"
                                    :class="{'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-200 dark:ring-indigo-500 dark:ring-offset-2 dark:outline-none dark:ring-2 dark:ring-offset-gray-800': activeTab === 'information', 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700': activeTab !== 'information'}"
                                    class="inline-flex items-center px-4 py-2 rounded-md font-semibold text-xs uppercase tracking-widest shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 w-full">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                     class="size-5">
                                    <path
                                        d="M10 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM3.465 14.493a1.23 1.23 0 0 0 .41 1.412A9.957 9.957 0 0 0 10 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 0 0-13.074.003Z"/>
                                </svg>
                                <span class="hidden sm:inline pl-2">{{ __('Information') }}</span>
                            </button>
                        </li>
                        @if(!is_null($curriculumId))
                            <li>
                                <button @click.prevent="activeTab = 'content'"
                                        :class="{'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-200 dark:ring-indigo-500 dark:ring-offset-2 dark:outline-none dark:ring-2 dark:ring-offset-gray-800': activeTab === 'content', 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700': activeTab !== 'content'}"
                                        class="inline-flex items-center px-4 py-2 rounded-md font-semibold text-xs uppercase tracking-widest shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 w-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                         class="size-5">
                                        <path
                                            d="m5.433 13.917 1.262-3.155A4 4 0 0 1 7.58 9.42l6.92-6.918a2.121 2.121 0 0 1 3 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 0 1-.65-.65Z"/>
                                        <path
                                            d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0 0 10 3H4.75A2.75 2.75 0 0 0 2 5.75v9.5A2.75 2.75 0 0 0 4.75 18h9.5A2.75 2.75 0 0 0 17 15.25V10a.75.75 0 0 0-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5Z"/>
                                    </svg>
                                    <span class="hidden sm:inline pl-2">{{ __('Content') }}</span>
                                </button>
                            </li>
                            <li>
                                <button @click.prevent="activeTab = 'version'"
                                        :class="{'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-200 dark:ring-indigo-500 dark:ring-offset-2 dark:outline-none dark:ring-2 dark:ring-offset-gray-800': activeTab === 'version', 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700': activeTab !== 'version'}"
                                        class="inline-flex items-center px-4 py-2 rounded-md font-semibold text-xs uppercase tracking-widest shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 w-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                         class="size-5">
                                        <path fill-rule="evenodd"
                                              d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13a.75.75 0 0 0-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 0 0 0-1.5h-3.25V5Z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                    <span class="hidden sm:inline pl-2">{{ __('Versions') }}</span>
                                </button>
                            </li>
                            <li>
                                <button @click.prevent="activeTab = 'result'"
                                        :class="{'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-200 dark:ring-indigo-500 dark:ring-offset-2 dark:outline-none dark:ring-2 dark:ring-offset-gray-800': activeTab === 'result', 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700': activeTab !== 'result'}"
                                        class="inline-flex items-center px-4 py-2 rounded-md font-semibold text-xs uppercase tracking-widest shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 w-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                         class="size-5">
                                        <path fill-rule="evenodd"
                                              d="M3 3.5A1.5 1.5 0 0 1 4.5 2h6.879a1.5 1.5 0 0 1 1.06.44l4.122 4.12A1.5 1.5 0 0 1 17 7.622V16.5a1.5 1.5 0 0 1-1.5 1.5h-11A1.5 1.5 0 0 1 3 16.5v-13Zm10.857 5.691a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 0 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                    <span class="hidden sm:inline pl-2">{{ __('Result') }}</span>
                                </button>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="w-3/4 p-6 text-gray-900 dark:text-gray-100">
                    <div x-show="activeTab === 'information'">
                        <livewire:forms.curriculum-form :curriculumId="$curriculumId"/>
                    </div>
                    @if(!is_null($curriculumId))
                        <div x-show="activeTab === 'content'">
                            <livewire:forms.curriculum-content-form :curriculumId="$curriculumId" :versionId="$versionId" />
                        </div>
                        <div x-show="activeTab === 'version'">
                            <livewire:curriculum-version :curriculumId="$curriculumId"/>
                        </div>
                        <div x-show="activeTab === 'result'">
                            <livewire:curriculum-result :curriculumId="$curriculumId"/>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
