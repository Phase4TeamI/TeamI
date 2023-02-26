<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Repository') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg py-2 px-3">
                <div class="w-full p-5">
                    <hr>
                    @foreach ($myrepositories as $myrepository)
                        <div class="mx-5 my-8">
                            <a href="{{ route('repository.show',$myrepository->id) }}" class="dark:text-gray-100">
                                <div class="flex items-center">
                                    <h1 class="text-2xl flex-1">{{$myrepository->name}}</h1>
                                    <div class="flex items-center">
                                        <img src="{{$myrepository->user->avatar_url}}" class="rounded-full w-8 h-auto flex-1">
                                        <h1 class="flex-1 px-2">{{$myrepository->user->name}}</h1>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <hr>
                    @endforeach
                    @foreach (Auth::user()->repositories as $joining)
                        <div class="mx-5 my-8">
                            <a href="{{ route('repository.show',$joining->id) }}" class="dark:text-gray-100">
                                <div class="flex items-center">
                                    <h1 class="text-2xl flex-1">{{$joining->name}}</h1>
                                    <div class="flex items-center">
                                        <img src="{{$joining->user->avatar_url}}" class="rounded-full w-8 h-auto flex-1">
                                        <h1 class="flex-1 px-2">{{$joining->user->name}}</h1>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
            <div class="py-6"></div>
            <a href="{{ route('repository.create') }}">
                <div class="bg-white dark:bg-gray-800 dark:text-gray-100 overflow-hidden shadow-sm sm:rounded-lg py-20 px-3 text-center" style="font-size: 100px;">
                    {{ __('Add Repository') }}
                </div>
            </a>
        </div>
    </div>
</x-app-layout>