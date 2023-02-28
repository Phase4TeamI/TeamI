<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Client\Factory;
use GuzzleHttp\Client;

use Carbon\Carbon;

use App\Library\IssueCacher;
use App\Library\PullCacher;
use App\Library\CommitCacher;
use App\Library\Compare;

use App\Models\User;
use App\Models\Repository;

class CompareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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

        return view('compare.index', compact('labels', 'new_compare_issues_1','new_compare_pulls_1', 'new_compare_commits_1', 'new_compare_issues_2','new_compare_pulls_2', 'new_compare_commits_2'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
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
        

        //比較1の処理

        //比較1の年月だけ求める 例：2022-02
        $data_1 = Compare::subDay($year1, $month1);

        //全てのイシューを取得する
        $OpenedIssues_1 = IssueCacher::getIssue(1);

        //配列を用意して入力した年と月のopen issueを取得する
        $new_OpenedIssues_1 = array();
        $new_OpenedIssues_1 = Compare::getOpened($OpenedIssues_1, $data_1);

        //クローズされたイシューを全件取得する
        $ClosedIssues_1 = IssueCacher::getClosedIssue(1);
        
        $new_ClosedIssues_1 = array();
        $new_ClosedIssues_1 = Compare::getClosed($ClosedIssues_1, $data_1);

        //最終的に格納する配列
        $new_compare_issues_1 = array();
        $new_compare_issues_1 = Compare::averageClose($new_ClosedIssues_1, $new_OpenedIssues_1);

        // -----------------------

        //全てのプルリクを取得する
        $OpenedPulls_1 = PullCacher::getPull(1);

        //配列を用意して入力した年と月のopen プルリクを取得する
        $new_OpenedPulls_1 = array();
        $new_OpenedPulls_1 = Compare::getOpened($OpenedPulls_1, $data_1);
        
        //クローズされたプルリクを全件取得する
        $ClosedPulls_1 = PullCacher::getClosedPull(1);
        
        //期間中にクローズされたプルリクを取得する
        $new_ClosedPulls_1 = array();
        $new_ClosedPulls_1 = Compare::getClosed($ClosedPulls_1, $data_1);
        
        //最終的に格納する配列
        $new_compare_pulls_1 = array();
        $new_compare_pulls_1 = Compare::averageClose($new_ClosedPulls_1, $new_OpenedPulls_1);

        // -----------------------

        // 全てのコミットを取得する
        $FullCommits_1 = CommitCacher::getFullCommit(1);
        
        //期間中のコミットを取得
        $new_Commits_1 = Compare::getCommit($FullCommits_1, $data_1);
        
        //最終的に格納する配列
        $new_compare_commits_1 = Compare::averageCommit($new_Commits_1, $firstOfMonth_1);


        // -----------------------------------------------------------------------------------------------
        //比較2の処理

        //比較2の年月だけ求める 例：2022-02
        $data_2 = Compare::subDay($year2, $month2);

        //全てのイシューを取得する
        $OpenedIssues_2 = IssueCacher::getIssue(1);

        //配列を用意して入力した年と月のopen issueを取得する
        $new_OpenedIssues_2 = array();
        $new_OpenedIssues_2 = Compare::getOpened($OpenedIssues_2, $data_2);

        //クローズされたイシューを全件取得する
        $ClosedIssues_2 = IssueCacher::getClosedIssue(1);
        
        $new_ClosedIssues_2 = array();
        $new_ClosedIssues_2 = Compare::getClosed($ClosedIssues_2, $data_2);

        //最終的に格納する配列
        $new_compare_issues_2 = array();
        $new_compare_issues_2 = Compare::averageClose($new_ClosedIssues_2, $new_OpenedIssues_2);

        // -----------------------

        //全てのプルリクを取得する
        $OpenedPulls_2 = PullCacher::getPull(1);

        //配列を用意して入力した年と月のopen プルリクを取得する
        $new_OpenedPulls_2 = array();
        $new_OpenedPulls_2 = Compare::getOpened($OpenedPulls_2, $data_2);
        
        //クローズされたプルリクを全件取得する
        $ClosedPulls_2 = PullCacher::getClosedPull(1);
        
        //期間中にクローズされたプルリクを取得する
        $new_ClosedPulls_2 = array();
        $new_ClosedPulls_2 = Compare::getClosed($ClosedPulls_2, $data_2);
        

        //最終的に格納する配列
        $new_compare_pulls_2 = array();
        $new_compare_pulls_2 = Compare::averageClose($new_ClosedPulls_2, $new_OpenedPulls_2);

        // -----------------------

        // 全てのコミットを取得する
        $FullCommits_2 = CommitCacher::getFullCommit(1);
        
        //期間中のコミットを取得
        $new_Commits_2 = Compare::getCommit($FullCommits_2, $data_2);
        
        //最終的に格納する配列
        $new_compare_commits_2 = Compare::averageCommit($new_Commits_2, $firstOfMonth_2);

        //達成度を求める
        $issue_achievement_1 = Compare::achievement(count($new_OpenedIssues_1), count($new_ClosedIssues_1));
        $issue_achievement_2 = Compare::achievement(count($new_OpenedIssues_2), count($new_ClosedIssues_2));
        $pull_achievement_1 = Compare::achievement(count($new_OpenedPulls_1), count($new_ClosedPulls_1));
        $pull_achievement_2 = Compare::achievement(count($new_OpenedPulls_2), count($new_ClosedPulls_2));

        return view('compare.index', compact('labels','new_compare_issues_1', 'new_compare_pulls_1', 'new_compare_commits_1', 'new_compare_issues_2', 'new_compare_pulls_2', 'new_compare_commits_2', 'issue_achievement_1', 'issue_achievement_2', 'pull_achievement_1', 'pull_achievement_2'));
    }


     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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

        return view('compare.index', compact('id','labels', 'new_compare_issues_1','new_compare_pulls_1', 'new_compare_commits_1', 'new_compare_issues_2','new_compare_pulls_2', 'new_compare_commits_2', 'issue_achievement_1', 'issue_achievement_2', 'pull_achievement_1', 'pull_achievement_2'));
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
        //
    }
}
