<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Register Repository') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-4">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <h2 class="mx-auto text-center text-xl font-medium text-gray-900 dark:text-gray-100">
                            {{ __('リポジトリの登録') }}
                        </h2>
                        <p class="mx-auto text-center mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __("既存のGitHubリポジトリを登録できます") }}
                        </p>
                        <form action="{{route('repository.store')}}" method="post" class="mt-6 space-y-6">
                            @csrf
                            <div>
                                <x-input-label for="name" :value="__('Repository Name')" />
                                <x-text-input name="name" type="text" class="mt-1 block w-full"/>
                            </div>
                            <div>
                                <x-input-label for="repository_url" :value="__('Repository URL')" />
                                <x-text-input name="repository_url" type="text" class="mt-1 block w-full"/>
                            </div>
                            <div>
                                <x-input-label for="webhook_secret" :value="__('Webhook Secret')" />
                                <x-text-input name="webhook_secret" type="text" class="mt-1 block w-full"/>
                            </div>
                            <div class="mx-auto text-center">
                                <x-primary-button>
                                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M2.63452 7.50001L13.6345 7.5M8.13452 13V2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                    Register Repository
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>