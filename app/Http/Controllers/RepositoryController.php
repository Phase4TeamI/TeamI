<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Validator;
use Auth;
use Carbon\Carbon;

use App\Models\Repository;
use App\Models\User;
use App\Models\Commit;

use App\Library\WebRequestSender;
use App\Library\IssueCacher;
use App\Library\PullCacher;
use App\Library\CommitCacher;
use App\Library\TimeExchanger;
use App\Library\ScoreManager;
use App\Library\Compare;

class RepositoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $myrepositories = Repository::query()
        ->where('user_id', Auth::id())
        ->orderBy('created_at','desc')
        ->get();
        return view('repository.index', compact('myrepositories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('repository.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        // バリデーション
        $validator = Validator::make($request->all(), [
            'name' => 'required | max:255',
            'repository_url' => 'required',
        ]);

        // バリデーションエラー
        if ($validator->fails()) {
            return redirect()->route('repository.create')->withInput()->withErrors($validator);
        }

        //APIにリポジトリを問い合わせ
        $api_uri = "https://api.github.com/repos/" . str_replace("https://github.com/", "", $request->input("repository_url"));
        
        $response = WebRequestSender::getResponse($api_uri);
        if (!isset($response)) {
            return redirect()->route('repository.create')->withInput();
        }


        // DBに格納
        // リポジトリの登録
        $request->merge(['user_id' => Auth::user()->id]);
        $request->merge(['repository_id' => $response["id"]]);
        $result = Repository::create($request->all());
        
        // Issueの登録
        IssueCacher::storeIssue($response['id']);
        PullCacher::storePull($response['id']);
        CommitCacher::storeCommit($response['id']);
        return redirect()->route('repository.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $repository = Repository::find($id);

        $issues = IssueCacher::getUserIssue($id, Auth::user()->id);
        $pulls  = PullCacher::getUserPull($id, Auth::user()->id);

        //Issueの情報を計算
        $stateIssue = array(
            "open" => 0,
            "closed" => 0,
            "average" => null,
        );
        $issueClosedAverage = [];
        foreach($issues as $issue) {
            if(isset($issue["closed_at"])) {
                $stateIssue["closed"]++;
                $issueClosedAverage[] = strtotime($issue["closed_at"]) - strtotime($issue["created_at"]);
            } else {
                $stateIssue["open"]++;
            }
        }
        //0で割ったときに出るエラーを回避
        if(count($issueClosedAverage) === 0){
            $stateIssue["average"] = 0;
        }
        else{
            $stateIssue["average"] = TimeExchanger::convertSecToHMS(floor(array_sum($issueClosedAverage) / count($issueClosedAverage)));
        }

        //Pullの情報を計算
        $statePull = array(
            "open" => 0,
            "merged" => 0,
            "average" => null,
        );
        $pullClosedAverage = [];
        foreach($pulls as $pull) {
            if(isset($pull["merged_at"])) {
                $statePull["merged"]++;
                $pullClosedAverage[] = strtotime($pull["merged_at"]) - strtotime($pull["created_at"]);
            } else {
                $statePull["open"]++;
            }
        }
        //0で割ったときに出るエラーを回避
        if( count($pullClosedAverage) === 0){
            $statePull["average"] = 0;
        }
        else{
            $statePull["average"] = TimeExchanger::convertSecToHMS(floor(array_sum($pullClosedAverage) / count($pullClosedAverage)));
        }
        

        //Commitの情報を計算
        $stateCommit = array(
            "commit" => 0,
            "average" => null,
        );
        //平均コミット量
        $queryCount = "count(case when repository_id = " . $id . " and provider_id = " . Auth::user()->provider_id . " then 1 else null end) as commit";
        $dayCommits = Commit::Query()
        ->selectRaw('date_format(committed_at, "%Y-%m-%d") as day')
        ->selectRaw($queryCount)
        ->groupBy('day')
        ->orderBy('day','asc')
        ->get()->toArray();
        
        $averageCommit = [];
        foreach($dayCommits as $dayCommit) {
            if($dayCommit["commit"] > 0) {
                $averageCommit[] = $dayCommit["commit"];
            }
        }
        //0で割ったときに出るエラーを回避
        if( count($averageCommit) === 0){
            $stateCommit["average"]= 0;
        }
        else{
            $stateCommit["average"] = floor(array_sum($averageCommit) / count($averageCommit));
        }
        
        $stateCommit["commit"] = Commit::Query()
        ->where('repository_id', $id)
        ->where('provider_id', Auth::user()->provider_id)
        ->get()->count();

        ScoreManager::storeScore($id, Auth::user()->id, date("Y"), date("m"));
        $monthlyScore  = ScoreManager::getUserMonthlyScore($id, Auth::user()->id);
        $scores  = ScoreManager::getUserScores($id, Auth::user()->id);
        
        $scoreArray = [];
        $i = 0;
        foreach($scores as $score) {
            if($i >= 10) {
                break;
            }
            $scoreArray[$score["day"]] = $score["score"];
            $i++;
        }
        $scoreArray = array_reverse($scoreArray);

        return view('repository.show', compact('repository', 'stateIssue', 'statePull', 'stateCommit', 'monthlyScore', 'scoreArray'));
    }

    public function indexCompare($id)
    {
        $repository = Repository::find($id);
        $labels[] = array(
            '20xx年', '20xx年'
        );

        $new_compare_issues_1[] = array(
            'opened'  => 0,
            'closed'  => 0,
            'ave_closed' => 0
        );
        
        $new_compare_pulls_1[] = array(
            'opened'  => 0,
            'closed'  => 0,
            'ave_closed' => 0
        );

        $new_compare_commits_1[] = array(
            'commit'  => 0,
            'ave_commit'  => 0
        );

        $new_compare_issues_2[] = array(
            'opened'  => 0,
            'closed'  => 0,
            'ave_closed' => 0
        );
        
        $new_compare_pulls_2[] = array(
            'opened'  => 0,
            'closed'  => 0,
            'ave_closed' => 0
        );

        $new_compare_commits_2[] = array(
            'commit'  => 0,
            'ave_commit'  => 0
        );

        $issue_achievement_1 = 0;
        $issue_achievement_2 = 0;
        $pull_achievement_1 = 0;
        $pull_achievement_2 = 0;

        $chart_1 = 0;
        $chart_2 = 0;

        return view('compare.index', compact('id','repository','labels', 'new_compare_issues_1','new_compare_pulls_1', 'new_compare_commits_1', 'new_compare_issues_2','new_compare_pulls_2', 'new_compare_commits_2', 'issue_achievement_1', 'issue_achievement_2', 'pull_achievement_1', 'pull_achievement_2', 'chart_1', 'chart_2'));
    }

    public function compare(Request $request, $id)
    {
        //リポジトリの情報を取得する
        $repository = Repository::find($id);
        // 比較1
        $year1 = $request->input('year1');
        $month1 = $request->input('month1');

        // 比較2
        $year2 = $request->input('year2');
        $month2 = $request->input('month2');

        //比較1の月初めと月末
        $firstOfMonth_1 = Carbon::create($year1, $month1, 1)->firstOfMonth();
        $lastOfMonth_1 = Carbon::create($year1, $month1, 1)->lastOfMonth();

        //比較2の月初めと月末
        $firstOfMonth_2 = Carbon::create($year2, $month2, 1)->firstOfMonth();
        $lastOfMonth_2 = Carbon::create($year2, $month2, 1)->lastOfMonth();

        //chart.jsに渡すためのlabelを作成
        $labels[] = array(
            $year1.'年'.$month1.'月', $year2.'年'.$month2.'月'
        );
        // ddd($labels);

        //比較1の処理

        //比較1の年月だけ求める 例：2022-02
        $data_1 = Compare::subDay($year1, $month1);

        //全てのイシューを取得する
        $OpenedIssues_1 = IssueCacher::getIssue($repository->id);

        //配列を用意して入力した年と月のopen issueを取得する
        $new_OpenedIssues_1 = array();
        $new_OpenedIssues_1 = Compare::getOpened($OpenedIssues_1, $data_1);

        //クローズされたイシューを全件取得する
        $ClosedIssues_1 = IssueCacher::getClosedIssue($repository->id);
        
        $new_ClosedIssues_1 = array();
        $new_ClosedIssues_1 = Compare::getClosed($ClosedIssues_1, $data_1);

        //最終的に格納する配列
        $new_compare_issues_1 = array();
        $new_compare_issues_1 = Compare::averageClose($new_ClosedIssues_1, $new_OpenedIssues_1);

        // -----------------------

        //全てのプルリクを取得する
        $OpenedPulls_1 = PullCacher::getPull($repository->id);

        //配列を用意して入力した年と月のopen プルリクを取得する
        $new_OpenedPulls_1 = array();
        $new_OpenedPulls_1 = Compare::getOpened($OpenedPulls_1, $data_1);
        
        //クローズされたプルリクを全件取得する
        $ClosedPulls_1 = PullCacher::getClosedPull($repository->id);
        
        //期間中にクローズされたプルリクを取得する
        $new_ClosedPulls_1 = array();
        $new_ClosedPulls_1 = Compare::getClosed($ClosedPulls_1, $data_1);
        
        //最終的に格納する配列
        $new_compare_pulls_1 = array();
        $new_compare_pulls_1 = Compare::averageClose($new_ClosedPulls_1, $new_OpenedPulls_1);

        // -----------------------

        // 全てのコミットを取得する
        $FullCommits_1 = CommitCacher::getFullCommit($repository->id);
        
        //期間中のコミットを取得
        $new_Commits_1 = Compare::getCommit($FullCommits_1, $data_1);
        
        //最終的に格納する配列
        $new_compare_commits_1 = Compare::averageCommit($new_Commits_1, $firstOfMonth_1);

        //チャートのデータを格納する配列
        $chart_1 = Compare::weekCommit($new_Commits_1, $firstOfMonth_1);



        // -----------------------------------------------------------------------------------------------
        //比較2の処理

        //比較2の年月だけ求める 例：2022-02
        $data_2 = Compare::subDay($year2, $month2);

        //全てのイシューを取得する
        $OpenedIssues_2 = IssueCacher::getIssue($repository->id);

        //配列を用意して入力した年と月のopen issueを取得する
        $new_OpenedIssues_2 = array();
        $new_OpenedIssues_2 = Compare::getOpened($OpenedIssues_2, $data_2);

        //クローズされたイシューを全件取得する
        $ClosedIssues_2 = IssueCacher::getClosedIssue($repository->id);
        
        $new_ClosedIssues_2 = array();
        $new_ClosedIssues_2 = Compare::getClosed($ClosedIssues_2, $data_2);

        //最終的に格納する配列
        $new_compare_issues_2 = array();
        $new_compare_issues_2 = Compare::averageClose($new_ClosedIssues_2, $new_OpenedIssues_2);

        // -----------------------

        //全てのプルリクを取得する
        $OpenedPulls_2 = PullCacher::getPull($repository->id);

        //配列を用意して入力した年と月のopen プルリクを取得する
        $new_OpenedPulls_2 = array();
        $new_OpenedPulls_2 = Compare::getOpened($OpenedPulls_2, $data_2);
        
        //クローズされたプルリクを全件取得する
        $ClosedPulls_2 = PullCacher::getClosedPull($repository->id);
        
        //期間中にクローズされたプルリクを取得する
        $new_ClosedPulls_2 = array();
        $new_ClosedPulls_2 = Compare::getClosed($ClosedPulls_2, $data_2);
        

        //最終的に格納する配列
        $new_compare_pulls_2 = array();
        $new_compare_pulls_2 = Compare::averageClose($new_ClosedPulls_2, $new_OpenedPulls_2);

        // -----------------------

        // 全てのコミットを取得する
        $FullCommits_2 = CommitCacher::getFullCommit($repository->id);
        
        //期間中のコミットを取得
        $new_Commits_2 = Compare::getCommit($FullCommits_2, $data_2);
        
        //最終的に格納する配列
        $new_compare_commits_2 = Compare::averageCommit($new_Commits_2, $firstOfMonth_2);

        //チャートのデータを格納する配列
        $chart_2 = Compare::weekCommit($new_Commits_2, $firstOfMonth_2);

        //達成度を求める
        $issue_achievement_1 = Compare::achievement(count($new_OpenedIssues_1), count($new_ClosedIssues_1));
        $issue_achievement_2 = Compare::achievement(count($new_OpenedIssues_2), count($new_ClosedIssues_2));
        $pull_achievement_1 = Compare::achievement(count($new_OpenedPulls_1), count($new_ClosedPulls_1));
        $pull_achievement_2 = Compare::achievement(count($new_OpenedPulls_2), count($new_ClosedPulls_2));

        return view('compare.index', compact('id','repository','labels','new_compare_issues_1', 'new_compare_pulls_1', 'new_compare_commits_1', 'new_compare_issues_2', 'new_compare_pulls_2', 'new_compare_commits_2', 'issue_achievement_1', 'issue_achievement_2', 'pull_achievement_1', 'pull_achievement_2', 'chart_1', 'chart_2'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = Repository::find($id)->delete();
        return redirect()->route('repository.index');
    }


    public function addUser(Request $request)
    {
        // バリデーション
        $validator = Validator::make($request->all(), [
            'mail' => 'required|email:filter'
        ]);

        $repository = Repository::find($request->input('id'));
        // バリデーションエラー
        if ($validator->fails()) {
            return view('repository.show', compainct('repository'));
        }
        
        $getUser = User::where('email', '=', $request->input('mail'))->first();

        $user = User::find($getUser->id);
        $user->repositories()->sync($request->input('id'));

        return view('repository.show', compact('repository'));
    }
}
