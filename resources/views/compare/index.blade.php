<x-app-layout>
  <div class="p-8">
    <div class="max-w-7xl flex flex-col">
      <div class="m-4">
        <form class = "flex justify-between" action="{{ route('compare.store') }}" method="post">
            @csrf
            <label for="year1">年1：</label>
            <input class = "h-8" type="text" name="year1" id="year1">
            <label for="month1">月1：</label>
            <input class = "h-8" type="text" name="month1" id="month1">

            <button type="submit" class="font-medium tracking-widest uppercase">
            比較する
            </button>

            <label for="year2">年2：</label>
            <input class = "h-8" type="text" name="year2" id="year2">
            <label for="month2">月2：</label>
            <input class = "h-8" type="text" name="month2" id="month2">
            
            
        </form>
      </div>

      <div class="flex w-full justify-between my-8 space-x-5">

        <div class=" w-1/2 flex flex-col justify-center">
          <div class="flex w-full space-x-3">
            <div class="rounded-xl shadow-lg h-48 border w-1/2 mx-auto">
                <p class="font-mono text-2xl font-bold m-4">
                  ISSUE
                </p> 
                @if(!isset($new_compare_1[0]["issue"]))
                <p>0</p>
                @else
                <p class="font-mono text-7xl text-center font-bold text-blue-500 m-4">
                {{$new_compare_1[0]["issue"]}}
                </p>
                @endif
            </div>

            <div class="rounded-xl shadow-lg h-48 border w-1/2">
              <p class="font-mono text-2xl font-bold text-green-500 m-4">
                COMMIT
              </p> 
            </div>
          </div>

          <div class="rounded-xl shadow-lg  border w-full">
            <p class="font-mono text-2xl font-bold m-4">
              PULL REQUSET
            </p> 
            @if(!isset($new_compare_1[0]["pull"]))
            <p>0</p>
            @else
            <p class="font-mono text-7xl text-center font-bold text-red-500 m-4">
            {{$new_compare_1[0]["pull"]}}
            @endif
          </div>
        </div>

        <!-- 比較2 -->
        <div class=" w-1/2 flex flex-col justify-center">
          <div class="flex w-full space-x-3">

            <div class="rounded-xl shadow-lg h-48 border w-1/2">
                <p class="font-mono text-2xl font-bold m-4">
                  ISSUE
                </p> 
                @if(!isset($new_compare_2[0]["issue"]))
                <p>0</p>
                @else
                <p class="font-mono text-7xl  text-center font-bold text-blue-500 m-4">
                {{$new_compare_2[0]["issue"]}}
                </p>
                @endif
            </div>

            <div class="rounded-xl shadow-lg h-48 border w-1/2">
              <p class="font-mono text-2xl font-bold text-green-500 m-4">
                COMMIT
              </p> 
            </div>

          </div>

          <div class="rounded-xl shadow-lg  border w-full">
            <p class="font-mono text-2xl font-bold m-4">
              PULL REQUSET
            </p> 
            @if(!isset($new_compare_2[0]["pull"]))
            <p>0</p>
            @else
            <p class="font-mono text-7xl text-center font-bold text-red-500 m-4">
            {{$new_compare_2[0]["pull"]}}
            </p>
            @endif
          </div>
        </div>


      </div>
    </div>
  </div>

    <!-- <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class= "dark:bg-gray-800 overflow-hidden  sm:rounded-lg">

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

                <div class="flex max-w-3xl p-6 ">

                    <div class="rounded-xl shadow-lg h-48 border ">
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

                    <div class="rounded-xl shadow-lg  border ">
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

                    <div class="rounded-xl shadow-lg h-48 border ">
                      <p class="font-mono text-2xl font-bold text-green-500 m-4">
                        COMMIT
                      </p> 
                    </div>


                </div>

            </div>
        </div>
    </div> -->
</x-app-layout>
