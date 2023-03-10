<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __($repository->name) }}
        </h2>
    </x-slot>

    <div class="pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="grid grid-cols-5 gap-5 p-6">
                  <!-- スコア -->
                  <div class="dark:text-white col-start-1 border rounded-xl shadow-lg col-span-2 ">
                    <div class="w-full  px-3 py-7 rounded-xl">
                      <h3 class="font-mono text-xl">SCORE</h3>
                      <p class="font-mono text-5xl mt-3">{{ $monthlyScore }}</p>
                    </div>
                  </div>

                  <!-- グラフ -->
                  <div class="flex items-center justify-center px-3 py-7 row-span-2 col-start-3 col-span-3 text-center shadow-lg border rounded-xl bg-white">
                    <canvas id="score"></canvas>
                  </div>

                  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
                  <script>
                    const scoreArray = @json($scoreArray);
                    let scoreLabel = Object.keys(scoreArray);
                    let scoreData  = Object.values(scoreArray);

                    let ctx = document.getElementById("score");
                    let scoreGraph = new Chart(ctx, {
                      type: "line",
                      data: {
                        labels: scoreLabel,
                        datasets: [{
                          label: "スコアの推移",
                          tension: 0,
                          fill: false,
                          borderColor: "red",
                          borderWidth: 2,
                          data: scoreData,
                        }],
                      },
                      options: {
                        responsive: true
                      }
                    })
                  </script>

                  <!-- 詳細 -->
                  <div class="dark:text-white border rounded-xl col-start-1 shadow-lg col-span-2">
                    <div class="w-full px-3 py-7 rounded-xl">
                      <div class="flex justify-between">
                        <h3 class="font-mono text-2xl">DETAILS</h3>
                        <div class="flex items-center px-3 py-2 rounded-md bg-blue-500 hover:bg-blue-400 transiton duration-200">
                          <a href="{{ route('repository.indexCompare',$repository->id) }}" class="flex text-white">
                          <div class="flex items-center">
                            <svg class="h-4 w-4 mr-1 text-white"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="6" cy="6" r="2" />  <circle cx="18" cy="18" r="2" />  <path d="M11 6h5a2 2 0 0 1 2 2v8" />  <polyline points="14 9 11 6 14 3" />  <path d="M13 18h-5a2 2 0 0 1 -2 -2v-8" />  <polyline points="10 15 13 18 10 21" /></svg>
                          </div>
                          Compare
                          </a>
                        </div>
                      </div>
                      <!-- issue情報 -->
                      <div class="flex mt-5 items-center justify-between ac-parent">
                        <div class="flex items-center ">
                          <svg class="h-5 w-5 text-gray-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="12" cy="12" r=".5" fill="currentColor" />  <circle cx="12" cy="12" r="9" /></svg>
                          <p class="font-mono text-lg uppercase ml-2">issues</p>
                        </div>

                        <div class="">
                          <p class="font-mono text-lg"></p>
                        </div>
                      </div>

                      <div class="ml-5 space-y-2 ac-child">

                        <div class="flex justify-between">
                          <p class="font-mono text-m ml-2">open Issues</p>
                          <p class="font-mono text-m">{{ $stateIssue["open"] }}</p>
                        </div>

                        <div class="flex justify-between">
                          <p class="font-mono text-m ml-2">closed issues</p>
                          <p class="font-mono text-m">{{ $stateIssue["closed"] }}</p>
                        </div>

                        <div class="flex justify-between">
                          <p class="font-mono text-m ml-2">average time to close</p>
                          <p class="font-mono text-m">{{ $stateIssue["average"] }}</p>
                        </div>

                      </div>

                      <!-- プルリク情報 -->
                      <div class="flex mt-5 items-center justify-between ac-parent">
                        <div class="flex items-center ">
                          <svg class="h-5 w-5 text-gray-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="6" cy="18" r="2" />  <circle cx="6" cy="6" r="2" />  <circle cx="18" cy="18" r="2" />  <line x1="6" y1="8" x2="6" y2="16" />  <path d="M11 6h5a2 2 0 0 1 2 2v8" />  <polyline points="14 9 11 6 14 3" /></svg>
                          <p class="font-mono text-lg uppercase ml-2">pull requests</p>
                        </div>
                      </div>

                      <div class="ml-5 ac-child space-y-2">
                        <div class="flex justify-between">
                          <p class="font-mono text-m ml-2">open pull requests</p>
                          <p class="font-mono text-m">{{ $statePull["open"] }}</p>
                        </div>

                        <div class="flex justify-between">
                          <p class="font-mono text-m ml-2">merged pull requests</p>
                          <p class="font-mono text-m">{{ $statePull["merged"] }}</p>
                        </div>

                        <div class="flex justify-between">
                          <p class="font-mono text-m ml-2">average time to merge</p>
                          <p class="font-mono text-m">{{ $statePull["average"] }}</p>
                        </div>
                      </div>

                      <!-- コミット情報 -->
                      <div class="flex mt-5 items-center justify-between ac-parent">
                        <div class="flex items-center ">
                          <svg class="h-5 w-5 text-gray-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="6" cy="18" r="2" />  <circle cx="6" cy="6" r="2" />  <circle cx="18" cy="18" r="2" />  <line x1="6" y1="8" x2="6" y2="16" />  <path d="M11 6h5a2 2 0 0 1 2 2v8" />  <polyline points="14 9 11 6 14 3" /></svg>
                          <p class="font-mono text-lg uppercase ml-2">Commits</p>
                        </div>
                      </div>

                      <div class="ml-5 ac-child space-y-2">
                        <div class="flex justify-between">
                          <p class="font-mono text-m ml-2">commits</p>
                          <p class="font-mono text-m">{{ $stateCommit["commit"] }}</p>
                        </div>

                        <div class="flex justify-between">
                          <p class="font-mono text-m ml-2">average daily commits</p>
                          <p class="font-mono text-m">{{ $stateCommit["average"] }}</p>
                        </div>
                      </div>                      
                    </div>
                  </div>

                </div>
            </div>
        </div>
    </div>

  

    @if ($repository->user_id === Auth::user()->id)
        <div class="pt-6">
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
    <div class="pt-6">
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