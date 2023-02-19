<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 py-2 px-3">あなたのリポジトリ</h2>
            </div>
            @foreach ($myrepositories as $myrepository)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg py-2 px-3">
                    <a href="{{ route('repository.show',$myrepository->id) }}" class="dark:text-gray-100">
                        {{$myrepository->name}}
                    </a>
                </div>
            @endforeach
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 py-2 px-3">参加中のリポジトリ</h2>
            </div>
            @foreach (Auth::user()->repositories as $joining)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg py-2 px-3">
                    <a href="{{ route('repository.show',$joining->id) }}" class="dark:text-gray-100">
                        {{$joining->name}}
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>