<x-app-layout>
  <div class="p-6 w-screen flex justify-center">
    <div class="w-screen max-w-[1400px] flex-col justify-center">
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

      <div class="flex w-full justify-between my-4 space-x-4">

        <div class=" w-1/2 flex flex-col justify-center items-center space-y-4">
          <div class="flex w-full space-x-4">

            <div class=" p-4 rounded-md shadow-md h-52 border w-1/2">
              <div class="flex-cols space-y-3">
                <div class="flex">
                  <svg class="h-6 w-6 pt-1 text-gray-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="12" cy="12" r=".5" fill="currentColor" />  <circle cx="12" cy="12" r="9" /></svg>
                    <p class="font-mono text-lg font-bold ml-2">
                      Issue
                    </p>  
                </div>

                
                  <div class="flex justify-between">
                    <p class="text-[12px] pl-1 pt-2">期間中にオープンしたイシューの数</p>
                    @if(!isset($new_compare_issue_1[0]["opened_issue"]))
                      <p class="font-mono text-2xl text-center font-bold text-blue-500">0</p>
                      @else
                      <p class="font-mono text-3xl text-center font-bold text-yellow-400">
                      {{$new_compare_issue_1[0]["opened_issue"]}}
                      </p>
                    @endif
                  </div>
  
                  <div class="flex justify-between">
                    <p class="text-[12px] pl-1 pt-2">期間中にクローズしたイシューの数</p>
                    @if(!isset($new_compare_issue_1[0]["closed_issue"]))
                      <p class="font-mono text-2xl text-center font-bold text-blue-500">0</p>
                      @else
                      <p class="font-mono text-3xl text-center font-bold text-yellow-400">
                      {{$new_compare_issue_1[0]["closed_issue"]}}
                      </p>
                    @endif
                  </div>

                  <div class="flex justify-between">
                    <p class="text-[12px] pl-1 pt-2">1issueあたりの平均クローズ時間</p>
                    @if(!isset($new_compare_issue_1[0]["ave_closed"]))
                      <p class="font-mono text-2xl text-center font-bold text-blue-500">0</p>
                      @else
                      <p class="font-mono text-3xl text-center font-bold text-yellow-400">
                      {{$new_compare_issue_1[0]["ave_closed"]}}
                      </p>
                    @endif
                  </div>
                
              </div>
              
            </div>

            <div class=" p-4 rounded-md shadow-md h-52 border w-1/2">
              <div class="flex-cols space-y-3">
                <div class="flex">
                  <svg class="h-7 w-7  text-gray-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="4" />  <line x1="1.05" y1="12" x2="7" y2="12" />  <line x1="17.01" y1="12" x2="22.96" y2="12" /></svg>
                    <p class="font-mono text-lg font-bold ml-2">
                      Commit
                    </p>  
                </div>

                
                  <div class="flex justify-between">
                    <p class="text-[12px] pl-1 pt-2">期間中のコミット数</p>
                    @if(!isset($new_compare_1[0]["issue"]))
                      <p class="font-mono text-2xl text-center font-bold text-blue-500">0</p>
                      @else
                      <p class="font-mono text-3xl text-center font-bold text-yellow-400">
                      {{$new_compare_1[0]["issue"]}}
                      </p>
                    @endif
                  </div>
  
                  <!-- <div class="flex justify-between">
                    <p class="text-[12px] pl-1 pt-2">1イシューあたりの平均クローズ時間</p>
                    @if(!isset($new_compare_1[0]["issue"]))
                      <p class="font-mono text-2xl text-center font-bold text-blue-500">0</p>
                      @else
                      <p class="font-mono text-3xl text-center font-bold text-yellow-400">
                      {{$new_compare_1[0]["issue"]}}
                      </p>
                    @endif
                  </div> -->
                
              </div>
              
            </div>
          </div>

          <div class=" p-4 rounded-md shadow-md h-52 border w-full">
              <div class="flex-cols space-y-3">
                <div class="flex">
                  <svg class="h-6 w-6  text-gray-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="6" cy="18" r="2" />  <circle cx="6" cy="6" r="2" />  <circle cx="18" cy="18" r="2" />  <line x1="6" y1="8" x2="6" y2="16" />  <path d="M11 6h5a2 2 0 0 1 2 2v8" />  <polyline points="14 9 11 6 14 3" /></svg>
                    <p class="font-mono text-lg font-bold ml-2">
                      Pull Request
                    </p>  
                </div>

                
                  <div class="flex justify-between">
                    <p class="text-[12px] pl-1 pt-2">期間中にオープンしたプルリクの数</p>
                    @if(!isset($new_compare_1[0]["issue"]))
                      <p class="font-mono text-2xl text-center font-bold text-blue-500">0</p>
                      @else
                      <p class="font-mono text-3xl text-center font-bold text-yellow-400">
                      {{$new_compare_1[0]["issue"]}}
                      </p>
                    @endif
                  </div>
  
                  <div class="flex justify-between">
                    <p class="text-[12px] pl-1 pt-2">1プルリクあたりの平均マージ・均クローズ時間</p>
                    @if(!isset($new_compare_1[0]["issue"]))
                      <p class="font-mono text-2xl text-center font-bold text-blue-500">0</p>
                      @else
                      <p class="font-mono text-3xl text-center font-bold text-yellow-400">
                      {{$new_compare_1[0]["issue"]}}
                      </p>
                    @endif
                  </div>
                
              </div>
              
            </div>
        </div>

        <!-- 比較2 -->
        <div class=" w-1/2 flex flex-col justify-center items-center space-y-4">
          <div class="flex w-full space-x-4">

            <div class=" p-4 rounded-md shadow-md h-52 border w-1/2">
              <div class="flex-cols space-y-3">
                <div class="flex">
                  <svg class="h-6 w-6 pt-1 text-gray-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="12" cy="12" r=".5" fill="currentColor" />  <circle cx="12" cy="12" r="9" /></svg>
                    <p class="font-mono text-lg font-bold ml-2">
                      Issue
                    </p>  
                </div>

                
                  <div class="flex justify-between">
                    <p class="text-[12px] pl-1 pt-2">期間中にオープンしたイシューの数</p>
                    @if(!isset($new_compare_1[0]["issue"]))
                      <p class="font-mono text-2xl text-center font-bold text-blue-500">0</p>
                      @else
                      <p class="font-mono text-3xl text-center font-bold text-yellow-400">
                      {{$new_compare_1[0]["issue"]}}
                      </p>
                    @endif
                  </div>
  
                  <div class="flex justify-between">
                    <p class="text-[12px] pl-1 pt-2">1イシューあたりの平均クローズ時間</p>
                    @if(!isset($new_compare_1[0]["issue"]))
                      <p class="font-mono text-2xl text-center font-bold text-blue-500">0</p>
                      @else
                      <p class="font-mono text-3xl text-center font-bold text-yellow-400">
                      {{$new_compare_1[0]["issue"]}}
                      </p>
                    @endif
                  </div>
                
              </div>
              
            </div>

            <div class=" p-4 rounded-md shadow-md h-52 border w-1/2">
              <div class="flex-cols space-y-3">
                <div class="flex">
                  <svg class="h-7 w-7  text-gray-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="4" />  <line x1="1.05" y1="12" x2="7" y2="12" />  <line x1="17.01" y1="12" x2="22.96" y2="12" /></svg>
                    <p class="font-mono text-lg font-bold ml-2">
                      Commit
                    </p>  
                </div>

                
                  <div class="flex justify-between">
                    <p class="text-[12px] pl-1 pt-2">期間中のコミット数</p>
                    @if(!isset($new_compare_1[0]["issue"]))
                      <p class="font-mono text-2xl text-center font-bold text-blue-500">0</p>
                      @else
                      <p class="font-mono text-3xl text-center font-bold text-yellow-400">
                      {{$new_compare_1[0]["issue"]}}
                      </p>
                    @endif
                  </div>
  
                  <!-- <div class="flex justify-between">
                    <p class="text-[12px] pl-1 pt-2">1イシューあたりの平均クローズ時間</p>
                    @if(!isset($new_compare_1[0]["issue"]))
                      <p class="font-mono text-2xl text-center font-bold text-blue-500">0</p>
                      @else
                      <p class="font-mono text-3xl text-center font-bold text-yellow-400">
                      {{$new_compare_1[0]["issue"]}}
                      </p>
                    @endif
                  </div> -->
                
              </div>
              
            </div>
          </div>

          <div class=" p-4 rounded-md shadow-md h-52 border w-full">
              <div class="flex-cols space-y-3">
                <div class="flex">
                  <svg class="h-6 w-6  text-gray-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="6" cy="18" r="2" />  <circle cx="6" cy="6" r="2" />  <circle cx="18" cy="18" r="2" />  <line x1="6" y1="8" x2="6" y2="16" />  <path d="M11 6h5a2 2 0 0 1 2 2v8" />  <polyline points="14 9 11 6 14 3" /></svg>
                    <p class="font-mono text-lg font-bold ml-2">
                      Pull Request
                    </p>  
                </div>

                
                  <div class="flex justify-between">
                    <p class="text-[12px] pl-1 pt-2">期間中にオープンしたプルリクの数</p>
                    @if(!isset($new_compare_1[0]["issue"]))
                      <p class="font-mono text-2xl text-center font-bold text-blue-500">0</p>
                      @else
                      <p class="font-mono text-3xl text-center font-bold text-yellow-400">
                      {{$new_compare_1[0]["issue"]}}
                      </p>
                    @endif
                  </div>
  
                  <div class="flex justify-between">
                    <p class="text-[12px] pl-1 pt-2">1プルリクあたりの平均マージ・均クローズ時間</p>
                    @if(!isset($new_compare_1[0]["issue"]))
                      <p class="font-mono text-2xl text-center font-bold text-blue-500">0</p>
                      @else
                      <p class="font-mono text-3xl text-center font-bold text-yellow-400">
                      {{$new_compare_1[0]["issue"]}}
                      </p>
                    @endif
                  </div>
                
              </div>
              
            </div>
        </div>
      </div>


      <div class="w-full p-4 rounded-xl shadow-lg flex justify-center border relative h-80">
        <div class="w-1/2">
          <canvas class =""id="myChart"></canvas>
        </div>

        <div class="w-1/2">
          <!-- <canvas class =""id="myChart"></canvas> -->
        </div>
      </div>

    </div>
  </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var labels = @json($labels);
    var data_1 = @json($new_compare_issue_1);
    
    
    console.log(data_1);
    const myChart = new Chart(ctx, {
    type: "bar",
    data: {
          labels: [labels[0][0],labels[0][0]],
          datasets: [{
            label: "issue",
            data: [data_1[0]["opened_issue"], data_1[0]["opened_issue"]],
            backgroundColor: ['#4169e1']
          },{
            label: "pull request",
            data: [data_1[0]["closed_issue"], data_1[0]["closed_issue"]],
            backgroundColor: ['#ffa500']
          },{
            label: "commit",
            data: [data_1[0]["ave_closed"], data_1[0]["ave_closed"]],
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

