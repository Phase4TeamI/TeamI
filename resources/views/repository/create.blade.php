<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('リポジトリの登録') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __("既存のGitHubリポジトリを登録します") }}
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
                            <x-primary-button>{{ __('Register repository') }}</x-primary-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>