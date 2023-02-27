<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>ProducTrack</title>

		@vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/index.js', 'resources/css/index.css'])

		<style>
			.backvideo {
				z-index: -1;
				position: fixed;
				width: 100%;
				top: 0;
				right: 0;
				bottom: 0;
				left: 0;
			}
		</style>
	</head>

	<body>
		<video src="{{ asset('images/back_mov.mp4')}}" loop muted autoplay playsinline class="backvideo">
		</video>
		<div class="h-screen flex justify-center items-center relative overflow-hidden before:absolute before:top-0 before:left-1/2 before:bg-no-repeat before:bg-top before:w-full before:h-full before:-z-[1] before:transform before:-translate-x-1/2 ">
			<div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-20 rounded-md backdrop-blur-lg backdrop-blur-sm bg-black/30">
				<!-- Announcement Banner -->
				<div class="flex justify-center">
					<a class="inline-flex items-center gap-x-2 bg-white border border-gray-200 text-xs text-gray-600 p-2 px-3 rounded-full transition hover:border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:hover:border-gray-600 dark:text-gray-400" href="https://github.com/Phase4TeamI/TeamI">
						Our Repository
						<span class="flex items-center gap-x-1">
							<span class="border-l border-gray-200 text-blue-600 pl-2 dark:text-blue-500">Check</span>
							<svg class="w-2.5 h-2.5 text-blue-600" width="16" height="16" viewBox="0 0 16 16" fill="none">
									<path d="M5.27921 2L10.9257 7.64645C11.1209 7.84171 11.1209 8.15829 10.9257 8.35355L5.27921 14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
							</svg>
						</span>
					</a>
				</div>
				<!-- End Announcement Banner -->

				<!-- Title -->
				<div class="mt-5 max-w-7xl text-center mx-auto">
					<h1 class="block font-bold text-gray-800 text-8xl md:text-7xl lg:text-8xl dark:text-gray-200">
							ProducTrack
					</h1>
				</div>
				<!-- End Title -->

				<div class="mt-5 max-w-3xl text-center mx-auto">
					<p class="text-2xl text-gray-600 dark:text-gray-400">エンジニアの生産性を可視化、<br>より効率的かつ生産性の高いチームを実現。</p>
				</div>

				<!-- Buttons -->
				@if (Route::has('login'))
				<div class="mt-8 grid gap-3 w-full sm:inline-flex sm:justify-center">
						@auth
						<a class="inline-flex justify-center items-center gap-x-3 text-center bg-gradient-to-tl from-blue-600 to-violet-600 hover:from-violet-600 hover:to-blue-600 border border-transparent text-white text-sm font-medium rounded-full focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 focus:ring-offset-white py-3 px-4 dark:focus:ring-offset-gray-800" href="{{ url('/dashboard') }}">
								<svg class="w-4.5 h-4.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
								<path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z"></path>
								</svg>
								Your Dashboard
						</a>
						@else
						<a class="inline-flex justify-center items-center gap-x-3 text-center bg-gradient-to-tl from-blue-600 to-violet-600 hover:from-violet-600 hover:to-blue-600 border border-transparent text-white text-sm font-medium rounded-full focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 focus:ring-offset-white py-3 px-4 dark:focus:ring-offset-gray-800" href="<?php echo url('/login/github'); ?>">
								<svg class="w-4.5 h-4.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
								<path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z"></path>
								</svg>
								Continue with Github
						</a>
						@endauth
				</div>
				@endif
				<!-- End Buttons -->
			</div>
		</div>
	</body>
</html>
