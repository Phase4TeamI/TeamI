<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Validator;
use Auth;

use App\Models\Repository;
use App\Models\User;
use App\Models\Commit;

use App\Library\WebRequestSender;
use App\Library\IssueCacher;
use App\Library\PullCacher;
use App\Library\CommitCacher;
use App\Library\TimeExchanger;
use App\Library\ScoreManager;

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
        $stateIssue["average"] = TimeExchanger::convertSecToHMS(floor(array_sum($issueClosedAverage) / count($issueClosedAverage)));

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
        $statePull["average"] = TimeExchanger::convertSecToHMS(floor(array_sum($pullClosedAverage) / count($pullClosedAverage)));

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
        $stateCommit["average"] = floor(array_sum($averageCommit) / count($averageCommit));
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
