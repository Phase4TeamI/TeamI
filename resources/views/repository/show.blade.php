<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __($repository->name) }}
        </h2>
    </x-slot>
    @if ($repository->user_id === Auth::user()->id)
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('管理者用メニュー') }}
                            </h2>
                            <form action="{{ route('repository.adduser', $repository) }}" method="post" class="mt-6 space-y-6">
                                @csrf
                                <div>
                                    <input type="hidden" name="id" value="{{$repository->id}}">
                                    <x-input-label for="mail" :value="__('メールアドレス')" />
                                    <x-text-input name="mail" type="text" class="mt-1 block w-full"/>
                                </div>
                                <x-primary-button>{{ __('追加') }}</x-primary-button>
                            </form>
                            <div class="py-2">
                            </div>
                            @include('repository.partials.delete-repository')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('参加中のユーザー') }}
                        </h2>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 py-4">オーナー</h2>
                        <p class="dark:text-gray-100">{{$repository->user->name}}</p>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 py-4">メンバー</h2>
                        @foreach ($repository->users as $member)
                            <p class="dark:text-gray-100">{{$member->name}}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>