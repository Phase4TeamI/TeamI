<x-app-layout>

    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden  sm:rounded-lg">
                <div class="grid grid-cols-5 gap-5 p-6">
                  <!-- スコア -->
                  <div class="dark:text-white col-start-1 border rounded-xl shadow-lg col-span-2 ">
                    <div class="w-full  px-3 py-7 rounded-xl">
                      <h3 class="font-mono text-xl">SCORE</h3>
                      <p class="font-mono text-5xl mt-3">3356</p>
                    </div>
                  </div>

                  <!-- グラフ -->
                  <div class="dark:text-white flex items-center justify-center px-3 py-7 row-span-2 col-start-3 col-span-3 text-center shadow-lg border rounded-xl">
                    <canvas id="myChart"></canvas>
                  </div>

                  <!-- 詳細 -->
                  <div class="dark:text-white border rounded-xl col-start-1 shadow-lg col-span-2">
                    <div class="w-full px-3 py-7 rounded-xl">
                      <h3 class="font-mono text-2xl">DETAILS</h3>

                      <!-- issue情報 -->
                      <div class="flex mt-5 items-center justify-between ac-parent">
                        <div class="flex items-center ">
                          <svg class="h-5 w-5 text-gray-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="12" cy="12" r=".5" fill="currentColor" />  <circle cx="12" cy="12" r="9" /></svg>
                          <p class="font-mono text-lg uppercase">　issues</p>
                        </div>

                        <div class="">
                          <p class="font-mono text-lg"></p>
                        </div>
                      </div>

                      <div class="ml-5 space-y-2 ac-child">

                        <div class="flex justify-between">
                          <p class="font-mono text-lg mt-2">　オープンしているissues</p>
                          <p class="font-mono text-lg">{{$issues[0]["open"]}}</p>
                        </div>

                        <div class="flex justify-between">
                          <p class="font-mono text-lg ">　クローズしたissue</p>
                          <p class="font-mono text-lg">{{$issues[0]["close"]}}</p>
                        </div>

                        <div class="flex justify-between">
                          <p class="font-mono text-lg ">　1issueあたりの平均クローズ時間</p>
                          <p class="font-mono text-lg">{{$issues[0]["ave_close"]}}H</p>
                        </div>

                      </div>

                      <!-- プルリク情報 -->
                      <div class="flex mt-5 items-center justify-between ac-parent">
                        <div class="flex items-center ">
                          <svg class="h-5 w-5 text-gray-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="6" cy="18" r="2" />  <circle cx="6" cy="6" r="2" />  <circle cx="18" cy="18" r="2" />  <line x1="6" y1="8" x2="6" y2="16" />  <path d="M11 6h5a2 2 0 0 1 2 2v8" />  <polyline points="14 9 11 6 14 3" /></svg>
                          <p class="font-mono text-lg uppercase">　pull requests</p>
                        </div>
                      </div>

                      <div class="ml-5 ac-child space-y-2">
                        <div class="flex justify-between">
                          <p class="font-mono text-lg mt-2">　オープンしているプルリク</p>
                          <p class="font-mono text-lg">{{$pulls[0]["open"]}}</p>
                        </div>

                        <div class="flex justify-between">
                          <p class="font-mono text-lg ">　クローズしたプルリク</p>
                          <p class="font-mono text-lg">{{$pulls[0]["close"]}}</p>
                        </div>

                        <div class="flex justify-between">
                          <p class="font-mono text-lg ">　1プルリクあたりの平均マージ・クローズ時間</p>
                          <p class="font-mono text-lg">{{$pulls[0]["ave_merge"]}}H</p>
                        </div>
                      </div>

                      <!-- コミット情報 -->
                      <div class="flex mt-5 items-center justify-between ac-parent">
                        <div class="flex items-center">
                          <svg class="h-5 w-5 text-gray-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="12" cy="12" r=".5" fill="currentColor" />  <circle cx="12" cy="12" r="9" /></svg>
                          <p class="font-mono text-lg uppercase">　commits</p>
                        </div>

                        <div>
                          <p class="font-mono text-lg"></p>
                        </div>
                      </div>

                      <div class="ml-5 ac-child">
                        <p class="font-mono text-lg uppercase">　issues</p>
                        <p class="font-mono text-lg uppercase">　issues</p>
                        <p class="font-mono text-lg uppercase">　issues</p>
                        <p class="font-mono text-lg uppercase">　issues</p>
                      </div>

                      <!-- メンバー情報 -->
                      <div class="flex mt-5 items-center justify-between ac-parent">
                        <div class="flex items-center">
                          <svg class="h-5 w-5 text-gray-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22" /></svg>
                          <p class="font-mono text-lg uppercase">　member</p>
                        </div>

                        <div>
                          <p class="font-mono text-lg"></p>
                        </div>
                      </div>

                      <div class="ml-5 ac-child">
                        <p class="font-mono text-lg uppercase">　issues</p>
                        <p class="font-mono text-lg uppercase">　issues</p>
                        <p class="font-mono text-lg uppercase">　issues</p>
                        <p class="font-mono text-lg uppercase">　issues</p>
                      </div>
                      
                    </div>
                  </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
