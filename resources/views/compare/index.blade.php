<x-app-layout>
  <div class="p-6 w-screen flex justify-center">
    <div class="w-screen max-w-[1500px] flex-col justify-center">
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
                    <p class="text-[12px] pl-1 pt-2">期間中にオープンしたイシュー</p>
                    @if(!isset($new_compare_issues_1[0]["opened"]))
                      <p class="font-mono text-3xl text-center font-bold text-blue-600">0</p>
                      @else
                      <p class="font-mono text-3xl text-center font-bold text-blue-600">
                      {{$new_compare_issues_1[0]["opened"]}}<span class="text-sm ml-1">件</span>
                      </p>
                    @endif
                  </div>
  
                  <div class="flex justify-between">
                    <p class="text-[12px] pl-1 pt-2">期間中にクローズしたイシュー</p>
                    @if(!isset($new_compare_issues_1[0]["closed"]))
                      <p class="font-mono text-3xl text-center font-bold text-blue-600">0</p>
                      @else
                      <p class="font-mono text-3xl text-center font-bold text-blue-600">
                      {{$new_compare_issues_1[0]["closed"]}}<span class="text-sm ml-1">件</span>
                      </p>
                    @endif
                  </div>

                  <div class="flex justify-between">
                    <p class="text-[12px] pl-1 pt-2">1issueあたりの平均クローズ時間</p>
                    @if(!isset($new_compare_issues_1[0]["ave_closed"]))
                      <p class="font-mono text-3xl text-center font-bold text-blue-600">0</p>
                      @else
                      <p class="font-mono text-3xl text-center font-bold text-blue-600">
                      {{$new_compare_issues_1[0]["ave_closed"]}}<span class="">H</span>
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
                    @if(!isset($new_compare_commits_1[0]["commit"]))
                      <p class="font-mono text-3xl text-center font-bold text-green-500">0</p>
                      @else
                      <p class="font-mono text-3xl text-center font-bold text-green-500">
                      {{$new_compare_commits_1[0]["commit"]}}<span class="text-sm ml-1">コミット</span>
                      </p>
                    @endif
                  </div>

                  <div class="flex justify-between">
                    <p class="text-[12px] pl-1 pt-2">1日あたりの平均コミット数</p>
                    @if(!isset($new_compare_commits_1[0]["ave_commit"]))
                      <p class="font-mono text-3xl text-center font-bold text-green-500">0</p>
                      @else
                      <p class="font-mono text-3xl text-center font-bold text-green-500">
                      {{$new_compare_commits_1[0]["ave_commit"]}}<span class="text-sm ml-1">コミット</span>
                      </p>
                    @endif
                  </div>
                
              </div>
              
            </div>
          </div>

          <div class=" p-4 rounded-md shadow-md h-52 border w-full">
              <div class="flex-cols space-y-3 ">
                <div class="flex">
                  <svg class="h-6 w-6  text-gray-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="6" cy="18" r="2" />  <circle cx="6" cy="6" r="2" />  <circle cx="18" cy="18" r="2" />  <line x1="6" y1="8" x2="6" y2="16" />  <path d="M11 6h5a2 2 0 0 1 2 2v8" />  <polyline points="14 9 11 6 14 3" /></svg>
                    <p class="font-mono text-lg font-bold ml-2">
                      Pull Request
                    </p>  
                </div>

                
                  <div class="flex justify-between">
                    <p class="text-[12px] pl-1 pt-2">期間中にオープンしたプルリクエスト</p>
                    @if(!isset($new_compare_pulls_1[0]["opened"]))
                      <p class="font-mono text-3xl text-center font-bold text-orange-500">0</p>
                      @else
                      <p class="font-mono text-3xl text-center font-bold text-orange-500">
                      {{$new_compare_pulls_1[0]["opened"]}}<span class="text-sm ml-1">件</span>
                      </p>
                    @endif
                  </div>

                  <div class="flex justify-between">
                    <p class="text-[12px] pl-1 pt-2">期間中にクローズしたプルリクエスト</p>
                    @if(!isset($new_compare_pulls_1[0]["closed"]))
                      <p class="font-mono text-3xl text-center font-bold text-orange-500">0</p>
                      @else
                      <p class="font-mono text-3xl text-center font-bold text-orange-500">
                      {{$new_compare_pulls_1[0]["closed"]}}<span class="text-sm ml-1">件</span>
                      </p>
                    @endif
                  </div>
  
                  <div class="flex justify-between">
                    <p class="text-[12px] pl-1 pt-2">1プルリクエストあたりの平均マージ・均クローズ時間</p>
                    @if(!isset($new_compare_pulls_1[0]["ave_closed"]))
                      <p class="font-mono text-3xl text-center font-bold text-orange-500">0</p>
                      @else
                      <p class="font-mono text-3xl text-center font-bold text-orange-500">
                      {{$new_compare_pulls_1[0]["ave_closed"]}}<span class="">H</span>
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
                    <p class="text-[12px] pl-1 pt-2">期間中にオープンしたイシュー</p>
                    @if(!isset($new_compare_issues_2[0]["opened"]))
                      <p class="font-mono text-3xl text-center font-bold text-blue-600">0</p>
                      @else
                      <p class="font-mono text-3xl text-center font-bold text-blue-600">
                      {{$new_compare_issues_2[0]["opened"]}}<span class="text-sm ml-1">件</span>
                      </p>
                    @endif
                  </div>

                  <div class="flex justify-between">
                    <p class="text-[12px] pl-1 pt-2">期間中にクローズしたイシュー</p>
                    @if(!isset($new_compare_issues_2[0]["closed"]))
                      <p class="font-mono text-3xl text-center font-bold text-blue-600">0</p>
                      @else
                      <p class="font-mono text-3xl text-center font-bold text-blue-600">
                      {{$new_compare_issues_2[0]["closed"]}}<span class="text-sm ml-1">件</span>
                      </p>
                    @endif
                  </div>
  
                  <div class="flex justify-between">
                    <p class="text-[12px] pl-1 pt-2">1issueあたりの平均クローズ時間</p>
                    @if(!isset($new_compare_issues_2[0]["ave_closed"]))
                      <p class="font-mono text-3xl text-center font-bold text-blue-600">0</p>
                      @else
                      <p class="font-mono text-3xl text-center font-bold text-blue-600">
                      {{$new_compare_issues_2[0]["ave_closed"]}}<span class="">H</span>
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
                    @if(!isset($new_compare_commits_2[0]["commit"]))
                      <p class="font-mono text-3xl text-center font-bold text-green-500">0</p>
                      @else
                      <p class="font-mono text-3xl text-center font-bold text-green-500">
                      {{$new_compare_commits_2[0]["commit"]}}<span class="text-sm ml-1">コミット</span>
                      </p>
                    @endif
                  </div>

                  <div class="flex justify-between">
                    <p class="text-[12px] pl-1 pt-2">1日あたりの平均コミット数</p>
                    @if(!isset($new_compare_commits_2[0]["ave_commit"]))
                      <p class="font-mono text-3xl text-center font-bold text-green-500">0</p>
                      @else
                      <p class="font-mono text-3xl text-center font-bold text-green-500">
                      {{$new_compare_commits_2[0]["ave_commit"]}}<span class="text-sm ml-1">コミット</span>
                      </p>
                    @endif
                  </div>
                
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
                    <p class="text-[12px] pl-1 pt-2">期間中にオープンしたプルリク</p>
                    @if(!isset($new_compare_pulls_2[0]["opened"]))
                      <p class="font-mono text-3xl text-center font-bold text-orange-500">0</p>
                      @else
                      <p class="font-mono text-3xl text-center font-bold text-orange-500">
                      {{$new_compare_pulls_2[0]["opened"]}}<span class="text-sm ml-1">件</span>
                      </p>
                    @endif
                  </div>

                  <div class="flex justify-between">
                    <p class="text-[12px] pl-1 pt-2">期間中にクローズしたプルリク</p>
                    @if(!isset($new_compare_pulls_2[0]["closed"]))
                      <p class="font-mono text-3xl text-center font-bold text-orange-500">0</p>
                      @else
                      <p class="font-mono text-3xl text-center font-bold text-orange-500">
                      {{$new_compare_pulls_2[0]["closed"]}}<span class="text-sm ml-1">件</span>
                      </p>
                    @endif
                  </div>
  
                  <div class="flex justify-between">
                    <p class="text-[12px] pl-1 pt-2">1プルリクあたりの平均マージ・均クローズ時間</p>
                    @if(!isset($new_compare_pulls_2[0]["ave_closed"]))
                      <p class="font-mono text-3xl text-center font-bold text-orange-500">0</p>
                      @else
                      <p class="font-mono text-3xl text-center font-bold text-orange-500">
                      {{$new_compare_pulls_2[0]["ave_closed"]}}<span class="">H</span>
                      </p>
                    @endif
                  </div>
                
              </div>
              
            </div>
        </div>
      </div>


      <div class="w-full p-4 rounded-xl shadow-md flex justify-center border relative h-[350px]">
        <div class="w-1/2">
          <div class ="flex">
            <div class="flex items-center">
              <svg class="h-6 w-6 text-gray-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="12" cy="12" r="9" />  <path d="M9 12l2 2l4 -4" /></svg>
            </div>
            <p class="font-mono text-lg font-bold ml-2">
              Opened
            </p>  
          </div>

          <div class="h-72 flex justify-start  items-center">
            <canvas class ="ml-3"id="myChart1"></canvas>
          </div>
        </div>

        <div class="w-1/2">
          <div class ="flex ml-6">
            <div class="flex items-center">
              <svg class="h-6 w-6 text-gray-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="12" cy="12" r="9" />  <path d="M10 10l4 4m0 -4l-4 4" /></svg>
            </div>
            <p class="font-mono text-lg font-bold ml-2">
              Closed
            </p>  
          </div>

          <div class="h-72 flex justify-start  items-center">
            <canvas class ="ml-9"id="myChart2"></canvas>
          </div>
        </div>
      </div>

      <div class="w-full mt-4 p-4 rounded-xl shadow-md flex justify-between  border relative h-[360px]">

        <div class="flex-cols">
          <div class ="flex">
              <div class="">
                <svg class="h-6 w-6 mt-1 text-gray-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <polyline points="3 17 9 11 13 15 21 7" />  <polyline points="14 7 21 7 21 14" /></svg> 
              </div>
              <p class="font-mono text-lg font-bold ml-2">
                achievement
              </p>  
          </div>
        
          <div class="flex">
            <div class=" relative ml-8">
              <span class="absolute  text-4xl top-1/2 left-1/2 -translate-y-1 -translate-x-1/2">{{$issue_achievement_1}}%</span>
              <canvas class =""id="myChart3"></canvas>
            </div>

            <div class="relative ml-8">
              <span class="absolute  text-4xl top-1/2 left-1/2 -translate-y-1 -translate-x-1/2">{{$issue_achievement_2}}%</span>
              <canvas class =""id="myChart4"></canvas>
            </div>

            <div class="flex ml-36">
              <div class="relative">
                <span class="absolute  text-4xl top-1/2 left-1/2 -translate-y-1 -translate-x-1/2">{{$pull_achievement_1}}%</span>
                <canvas class =""id="myChart5"></canvas>
              </div>

              <div class="relative ml-8">
                <span class="absolute  text-4xl top-1/2 left-1/2 -translate-y-1 -translate-x-1/2">{{$pull_achievement_2}}%</span>
                <canvas class =""id="myChart6"></canvas>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>

      //myChart1 Opened比較
      var ctx1 = document.getElementById('myChart1').getContext('2d');
      var labels = @json($labels);
      
      //比較1
      var issue_1 = @json($new_compare_issues_1);
      var pull_1 = @json($new_compare_pulls_1);
      var commit_1 = @json($new_compare_commits_1);
      
      //比較2
      var issue_2 = @json($new_compare_issues_2);
      var pull_2 = @json($new_compare_pulls_2);
      var commit_2 = @json($new_compare_commits_2);

      //達成度
      var ac_issue_1 = @json($issue_achievement_1);
      var ac_issue_2 = @json($issue_achievement_2);
      var ac_pull_1 = @json($pull_achievement_1);
      var ac_pull_2 = @json($pull_achievement_2);

      const myChart1 = new Chart(ctx1, {
      type: "bar",
      data: {
            labels: [labels[0][0],labels[0][1]],
            datasets: [{
              label: "issue",
              data: [issue_1[0]["opened"], issue_2[0]["opened"]],
              backgroundColor: ['#3B82FF']
            },{
              label: "pull request",
              data: [pull_1[0]["opened"], pull_2[0]["opened"]],
              backgroundColor: ['#F97316']
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

    //myChart2 Closed比較
      var ctx2 = document.getElementById('myChart2').getContext('2d');
      const myChart2 = new Chart(ctx2, {
      type: "bar",
      data: {
            labels: [labels[0][0],labels[0][1]],
            datasets: [{
              label: "issue",
              data: [issue_1[0]["closed"], issue_2[0]["closed"]],
              backgroundColor: ['#3B82FF']
            },{
              label: "pull request",
              data: [pull_1[0]["closed"], pull_2[0]["closed"]],
              backgroundColor: ['#F97316']
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

    //myChart3 達成度グラフ
    var ctx3 = document.getElementById('myChart3').getContext('2d');
    const myChart3 = new Chart(ctx3, {
      type: "doughnut",
      data: {
            labels: [labels[0][0]+'Issueの達成度'],
            datasets: [{
              borderColor: 'transparent',
              label: "issue",
              data: [ac_issue_1, 100-ac_issue_1],
              backgroundColor: ['#3B82FF', 'rgba(255,255,255,0)']
            },],
      },   
      
    });

    //myChart4 達成度グラフ
    var ctx4 = document.getElementById('myChart4').getContext('2d');
    const myChart4 = new Chart(ctx4, {
      type: "doughnut",
      data: {
            labels: [labels[0][1]+'のIssueの達成度'],
            datasets: [{
              borderColor: 'transparent',
              label: "issue",
              data: [ac_issue_2, 100-ac_issue_2],
              backgroundColor: ['#3B82FF', 'rgba(255,255,255,0)']
            },],
      },   
      
    });

    //myChart5 達成度グラフ
    var ctx5 = document.getElementById('myChart5').getContext('2d');
    const myChart5 = new Chart(ctx5, {
      type: "doughnut",
      data: {
            labels: [labels[0][0]+'のPull Requestの達成度'],
            datasets: [{
              borderColor: 'transparent',
              label: "issue",
              data: [ac_pull_1, 100-ac_pull_1],
              backgroundColor: ['#F97316', 'rgba(255,255,255,0)']
            },],
      },   
      
    });

    //myChart6 達成度グラフ
    var ctx6 = document.getElementById('myChart6').getContext('2d');
    const myChart6 = new Chart(ctx6, {
      type: "doughnut",
      data: {
            labels: [labels[0][0]+'のPull Requestの達成度'],
            datasets: [{
              borderColor: 'transparent',
              label: "issue",
              data: [ac_pull_2, 100-ac_pull_2],
              backgroundColor: ['#F97316', 'rgba(255,255,255,0)']
            },],
      },   
      
    });

  </script>
</x-app-layout>

