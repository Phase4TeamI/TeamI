<x-app-layout>
    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden  sm:rounded-lg">

              <form action="{{ route('compare.store') }}" method="post">
                  @csrf
                  <label for="year1">年1：</label>
                  <input type="text" name="year1" id="year1">
                  <label for="month1">月1：</label>
                  <input type="text" name="month1" id="month1">
                  <br>
                  <label for="year2">年2：</label>
                  <input type="text" name="year2" id="year2">
                  <label for="month2">月2：</label>
                  <input type="text" name="month2" id="month2">
                  <br>
                  <button type="submit" class=" py-3 mt-6 font-medium tracking-widest uppercase bg-black ">
                  比較する
                  </button>
              </form>

                <div class="grid grid-cols-3 gap-5 p-6 ">

                    <div class="rounded-xl shadow-lg h-48 border col-start-1">
                      <p class="font-mono text-2xl font-bold m-4">
                        ISSUE
                      </p> 
                      @if(!isset($new_compare_1[0]["issue"]))
                      <p>0</p>
                      @else
                      <p class="font-mono text-2xl font-bold text-blue-500 m-4">
                      {{$new_compare_1[0]["issue"]}}
                      </p>
                      <p class="font-mono text-2xl font-bold text-blue-500 m-4">
                      {{$new_compare_2[0]["issue"]}}
                      </p>
                      @endif
                    </div>

                    <div class="rounded-xl shadow-lg  border col-start-2">
                      <p class="font-mono text-2xl font-bold m-4">
                        PULL REQUSET
                      </p> 
                      @if(!isset($new_compare_2[0]["pull"]))
                      <p>0</p>
                      @else
                      <p class="font-mono text-2xl font-bold text-red-500 m-4">
                      {{$new_compare_1[0]["pull"]}}
                      </p>
                      <p class="font-mono text-2xl font-bold text-red-500 m-4">
                      {{$new_compare_2[0]["pull"]}}
                      </p>
                      @endif
                    </div>

                    <div class="rounded-xl shadow-lg h-48 border col-start-3">
                      <p class="font-mono text-2xl font-bold text-green-500 m-4">
                        COMMIT
                      </p> 
                    </div>


                </div>

            </div>
        </div>
    </div>
</x-app-layout>
