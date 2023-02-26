<x-app-layout>
  <div class="p-6 flex justify-around">
    <div class="flex flex-col justify-center">
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

      <div class="flex w-full justify-between my-4 space-x-5">

        <div class=" w-1/2 flex flex-col justify-center">
          <div class="flex w-full space-x-3">
            <div class="rounded-xl shadow-lg h-40 border w-1/2 mx-auto">
                <p class="font-mono text-2xl font-bold m-4">
                  ISSUE
                </p> 
                @if(!isset($new_compare_1[0]["issue"]))
                <p class="font-mono text-7xl text-center font-bold text-blue-500 m-4">0</p>
                @else
                <p class="font-mono text-7xl text-center font-bold text-blue-500 m-4">
                {{$new_compare_1[0]["issue"]}}
                </p>
                @endif
            </div>

            <div class="rounded-xl shadow-lg h-40 border w-1/2">
              <p class="font-mono text-2xl font-bold text-green-500 m-4">
                COMMIT
              </p> 
            </div>
          </div>

          <div class="rounded-xl shadow-lg  border w-full h-40">
            <p class="font-mono text-2xl font-bold m-4">
              PULL REQUSET
            </p> 
            @if(!isset($new_compare_1[0]["pull"]))
            <p class="font-mono text-7xl text-center font-bold text-blue-500 m-4">0</p>
            @else
            <p class="font-mono text-7xl text-center font-bold text-blue-500 m-4">
            {{$new_compare_1[0]["pull"]}}
            @endif
          </div>
        </div>

        <!-- 比較2 -->
        <div class=" w-1/2 flex flex-col justify-center">
          <div class="flex w-full space-x-3">

            <div class="rounded-xl shadow-lg h-40 border w-1/2">
                <p class="font-mono text-2xl font-bold m-4">
                  ISSUE
                </p> 
                @if(!isset($new_compare_2[0]["issue"]))
                <p class="font-mono text-7xl text-center font-bold text-red-500 m-4">0</p>
                @else
                <p class="font-mono text-7xl  text-center font-bold text-red-500 m-4">
                {{$new_compare_2[0]["issue"]}}
                </p>
                @endif
            </div>

            <div class="rounded-xl shadow-lg h-40 border w-1/2">
              <p class="font-mono text-2xl font-bold text-green-500 m-4">
                COMMIT
              </p> 
            </div>

          </div>

          <div class="rounded-xl shadow-lg  border w-full h-40">
            <p class="font-mono text-2xl font-bold m-4">
              PULL REQUSET
            </p> 
            @if(!isset($new_compare_2[0]["pull"]))
            <p class="font-mono text-7xl text-center font-bold text-red-500 m-4">0</p>
            @else
            <p class="font-mono text-7xl text-center font-bold text-red-500 m-4">
            {{$new_compare_2[0]["pull"]}}
            </p>
            @endif
          </div>
        </div>
      </div>

      <div class="w-full  rounded-xl shadow-lg flex justify-center border relative h-80">
        <canvas class =""id="myChart"></canvas>
      </div>
    </div>
  </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    
    var data_1 = @json($new_compare_1);
    var data_2 = @json($new_compare_2);
    
    console.log(data_1);
    const myChart = new Chart(ctx, {
    type: "bar",
    data: {
          labels: ['2022年','2023年'],
          datasets: [{
            label: "issue",
            data: [data_1[0]["issue"], data_2[0]["issue"]],
            backgroundColor: ['#4169e1']
          },{
            label: "pull request",
            data: [data_1[0]["pull"], data_2[0]["pull"]],
            backgroundColor: ['#ffa500']
          },{
            label: "commit",
            data: [data_1[0]["issue"], data_2[0]["issue"]],
            backgroundColor: ['#fa8072']
          }],
    },       
    options: {
        indexAxis: "y",
        scales: {
            x: {
                beginAtZero: true,
            },
        },
    },
});
</script>
</x-app-layout>

