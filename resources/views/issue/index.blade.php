

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="">
                    <div class="flex flex-col">
                      <div class="border-b my-3">
                        <h3 class="dark:text-white font-bold text-lg mb-3">Open Issues</h3>
                        <table class="w-full">
                          <thead class="bg-white dark:bg-gray-800 border-b">
                            <tr class="w-full flex ">
                                <th class="w-3/12 py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                    Assigned
                                </th>
                                <th class="w-3/12 py-3 px-6 text-xs font-medium tracking-wider text-gray-700 uppercase dark:text-gray-400">
                                    Openからの経過時間
                                </th>
                                <th class="w-6/12 text-right py-3 px-6 text-xs font-medium tracking-wider text-gray-700 uppercase dark:text-gray-400">
                                    Title
                                </th>
                            </tr>
                          </thead>
                          <tbody class="bg-white dark:bg-gray-800">
                            @foreach($results as $result)
                            <tr class="w-full flex ">
                                <td class="w-3/12 py-3 px-4 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-200">
                                    {{$result["user"]}}
                                </td>
                                <td class="w-3/12 text-center  py-3 px-4 text-xs font-medium tracking-wider text-gray-700 uppercase dark:text-gray-200">
                                    {{$result["day"]}}日と{{$result["hour"]}}時間経過しています
                                </td>
                                <td class="w-6/12 text-right py-3 px-4 text-xs font-medium tracking-wider text-gray-700 uppercase dark:text-gray-200">
                                    {{$result["title"]}}
                                </td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
