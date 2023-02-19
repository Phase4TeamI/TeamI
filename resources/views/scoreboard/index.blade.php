<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Scoreboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="grid grid-cols-2 gap-5 p-6">

                  <!-- スコア -->
                  <div class="dark:text-white">
                    <div class="w-full border px-3 py-6 rounded-xl">
                      <h3 class="font-mono text-xl">SCORE</h3>
                      <p class="font-mono text-5xl mt-3">3356</p>
                    </div>
                  </div>

                  <!-- グラフ -->
                  <div class="dark:text-white flex items-center justify-center px-3 py-6 row-span-2 text-center border rounded-xl">グラフがきます</div>

                  <!-- 詳細 -->
                  <div class="dark:text-white">
                    <div class="w-full border px-3 py-6 rounded-xl">
                      <h3 class="font-mono text-xl">DETAILS</h3>
                      <p class="font-mono text-lg mt-3 uppercase">issues</p>
                      <p class="font-mono text-lg mt-3 uppercase">pull requests</p>
                      <p class="font-mono text-lg mt-3 uppercase">commits</p>
                      <p class="font-mono text-lg mt-3 uppercase">member</p>
                    </div>
                  </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
