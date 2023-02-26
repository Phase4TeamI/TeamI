<section class="space-y-6">
    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-repository-deletion')"
    >{{ __('リポジトリの削除') }}</x-danger-button>

    <x-modal name="confirm-repository-deletion" focusable>
        <form method="post" action="{{ route('repository.destroy', $repository->id) }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('本当にリポジトリを削除しますか？') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('説明') }}
            </p>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('Delete Repository') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
