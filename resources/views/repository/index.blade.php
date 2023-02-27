<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
				@vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/index.js', 'resources/css/index.css'])
			</head>
<body>
<x-app-layout>
  <x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
			{{ __('Repository') }}
		</h2>
	</x-slot>

<!-- Table Section -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
  <!-- Card -->
  <div class="flex flex-col">
    <div class="-m-1.5 overflow-x-auto">
      <div class="p-1.5 min-w-full inline-block align-middle">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-slate-900 dark:border-gray-700">
          <!-- Header -->
          <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-gray-700">
            <div>
              <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                登録したリポジトリ
              </h2>
            </div>

            <div>
              <div class="inline-flex gap-x-2">
                <a class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800" href="{{ route('repository.create') }}">
                  <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M2.63452 7.50001L13.6345 7.5M8.13452 13V2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                  </svg>
                  Register Repository
                </a>
              </div>
            </div>
          </div>
          <!-- End Header -->

          <!-- Table -->
          <table class="min-w-full mx-auto text-center divide-y divide-gray-200 dark:divide-gray-700">
          <!-- thead -->
						<thead class="bg-gray-50 dark:bg-slate-800">
              <tr>
                
                <th scope="col" class="px-6 py-3 text-left">
                  <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                      Repository Name
                    </span>
                  </div>
                </th>

								<th scope="col" class="px-6 py-3 text-left">
                  <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                      User Name
                    </span>
                  </div>
                </th>

                <th scope="col" class="px-6 py-3 text-left">
                  <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                      Created
                    </span>
                  </div>
                </th>

                <th scope="col" class="px-6 py-3 text-right"></th>
              </tr>
            </thead>
						<!-- theadここまで -->

						<!-- tbody -->
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
              @foreach ($myrepositories as $myrepository)
							<tr>

                <td class="h-px w-px whitespace-nowrap">
                  <div class="px-6 py-3">
                    <div class="flex items-center gap-x-3">   
                      <a href="{{ route('repository.show',$myrepository->id) }}" class="dark:text-gray-100">
												<div class="grow">
                        	<span class="block text-sm font-semibold text-gray-800 dark:text-gray-200">{{$myrepository->name}}</span>
												</div>
											</a>
                    </div>
                  </div>
                </td>

								<td class="h-px w-px whitespace-nowrap">
                  <div class="px-6 py-3">
                    <div class="flex items-center gap-x-3">   
                      <a href="{{ route('repository.show',$myrepository->id) }}" class="dark:text-gray-100">
												<div class="grow">
                        	<span class="block text-sm font-semibold text-gray-800 dark:text-gray-200">{{$myrepository->user->name}}</span>
												</div>
											</a>
                    </div>
                  </div>
                </td>
            
                <td class="h-px w-px whitespace-nowrap">
                  <div class="px-6 py-3">
                    <span class="text-sm text-gray-500">{{$myrepository->created_at}}</span>
                  </div>
                </td>

              </tr>
							@endforeach
            </tbody>
          </table>
          <!-- End Table -->

          <!-- Footer -->
          <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-t border-gray-200 dark:border-gray-700">
            <div>
              <p class="text-sm text-gray-600 dark:text-gray-400">
                <span class="font-semibold text-gray-800 dark:text-gray-200">{{ count($myrepositories) }}</span> results
              </p>
            </div>

            <div>
							<!-- controllerで pagenation を実装した場合にページを切り替えるためのボタン -->
              <div class="inline-flex gap-x-2">

                <button id="prev-button" type="button" class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm dark:bg-slate-900 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800">
                  <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                  </svg>
                  Prev
                </button>

                <button id="next-button" type="button" class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm dark:bg-slate-900 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800">
                  Next
                  <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                  </svg>
                </button>

								<script>
									// ボタン要素を取得する
									const button1 = document.getElementById('prev-button');
									const button2 = document.getElementById('next-button');

									// ボタンにクリックイベントを追加する
									button1.addEventListener('click', () => {
										// ボタンがクリックされたら、アラートを表示する
										alert('開発中です。');
									});

									button2.addEventListener('click', () => {
										// ボタンがクリックされたら、アラートを表示する
										alert('開発中です。');
									});
								</script>

              </div>
            </div>
          </div>
          <!-- End Footer -->
        </div>
      </div>
    </div>
  </div>
  <!-- End Card -->
</div>
<!-- End Table Section -->

	<!-- <div class="py-12">
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
		</div> -->



		<!-- <div class="py-6"></div>
			<a href="{{ route('repository.create') }}">
				<div class="bg-white dark:bg-gray-800 dark:text-gray-100 overflow-hidden shadow-sm sm:rounded-lg py-20 px-3 text-center" style="font-size: 100px;">
					{{ __('Add Repository') }}
				</div>
			</a>
		</div> -->
</x-app-layout>
</body>
</html>