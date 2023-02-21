<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <a href="#">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ __("Create Repository") }}
                    </div>
                </a>
            </div>
        </div>
    </div>

    

                        <div class="flex items-center ac-parent">
                          <svg class="h-5 w-5 text-gray-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="12" cy="12" r=".5" fill="currentColor" />  <circle cx="12" cy="12" r="9" /></svg>
                          <p class="font-mono text-lg uppercase">　issues</p>
                        </div>

                        

                      
                      <div class="ml-5 ac-child">
                        <p class="font-mono text-lg uppercase">　issues</p>
                        <p class="font-mono text-lg uppercase">　issues</p>
                        <p class="font-mono text-lg uppercase">　issues</p>
                        <p class="font-mono text-lg uppercase">　issues</p>
                      </div>
</x-app-layout>
