<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class ScoreboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //User_Agentの権限を許可する
        $ctx = stream_context_create(array(
            'http' => array(
                'method' => 'GET',
                'header' => 'User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; Touch; rv:11.0) like Gecko')
            )
        );

        //JSONデータが置かれているURL先を格納する

        //issueのURL
        $issue_url = "https://api.github.com/repos/phase4TeamI/TeamI/issues?client_id=df3c312a6607af1baa5b&client_secret=5a4d5a8dc7ba604ee3b965d18abe347741c05c09";
        $issue_close_url = "https://api.github.com/repos/phase4TeamI/TeamI/issues?state=closed";

        // pull requestのURL
        $pull_url = "https://api.github.com/repos/phase4TeamI/TeamI/pulls?client_id=df3c312a6607af1baa5b&client_secret=5a4d5a8dc7ba604ee3b965d18abe347741c05c09";
        $close_pull_url = "https://api.github.com/repos/phase4TeamI/TeamI/pulls?state=close?client_id=df3c312a6607af1baa5b&client_secret=5a4d5a8dc7ba604ee3b965d18abe347741c05c09";

        // //commit
        // $commit_url = "https://api.github.com/repos/phase4TeamI/TeamI/commits?client_id=df3c312a6607af1baa5b&client_secret=5a4d5a8dc7ba604ee3b965d18abe347741c05c09";
        // //members
        // $member_url = "https://api.github.com/orgs/Phase4TeamI/members?client_id=df3c312a6607af1baa5b&client_secret=5a4d5a8dc7ba604ee3b965d18abe347741c05c09";

        //JSONデータを全て文字列に読み込むためにjsonという変数を作製
        $issue_json = file_get_contents($issue_url, false, $ctx);
        $issue_close_json = file_get_contents($issue_close_url, false, $ctx);

        $pull_json = file_get_contents($pull_url, false, $ctx);
        $close_pull_json = file_get_contents($close_pull_url, false, $ctx);
        // $commit_json = file_get_contents($commit_url, false, $ctx);
        // $member_json = file_get_contents($member_url, false, $ctx);

        //文字化け対策
        $issue_json = mb_convert_encoding($issue_json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
        $issue_close_json = mb_convert_encoding($issue_close_json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');

        $pull_json = mb_convert_encoding($pull_json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
        $close_pull_json = mb_convert_encoding($close_pull_json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
        // $commit_json = mb_convert_encoding($commit_json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
        // $member_json = mb_convert_encoding($member_json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
        
        //第二引数にtrueを使用することで連想配列にすることができる
        $issue_ary = json_decode($issue_json,true);
        $issue_close_ary = json_decode($issue_close_json,true);

        $pull_ary = json_decode($pull_json,true);
        $close_pull_ary = json_decode($close_pull_json,true);
        // $commit_ary = json_decode($commit_json,true);
        // $member_ary = json_decode($member_json,true);

        
        $issue_count = count($issue_ary);
        $issue_close_count = count($issue_close_ary);
        
        $pull_count = count($pull_ary);
        $close_pull_count = count($close_pull_ary);

        // $commit_json_count = count($commit_ary);
        // $member_json_count = count($member_ary);

        if ($issue_close_ary === NULL){
            return;
        }else {

            //クローズissueにプルリクエストが含まれているのでプルリクを除く処理
            $new_close_issue = array();

            for($i = 0; $i <= $issue_close_count-1; $i++){
                //pullが含まれる場合はスキップする
                if(strpos($issue_close_ary[$i]["html_url"], 'https://github.com/Phase4TeamI/TeamI/pull/') !== false){
                    
                }
                else{
                    $new_close_issue[] = $issue_close_ary[$i];
                }
            }

            $hours = array();
            for($i = 0; $i <= count($new_close_issue); $i++){
                $created_at = new Carbon($new_close_issue[$i]["created_at"]);
                $closed_at = new Carbon($new_close_issue[$i]["closed_at"]);
                ddd($closed_at);
                ddd($created_at->diffInMinutes($closed_at));
            }

            ddd($new_close_issue);

            $issues[] = array(
                'open'  => $issue_count-$pull_count,
                'close' => $close_issue_count-$close_pull_count,
                // 'pull' => $pull_json_count,
                // 'commit'  => $commit_json_count,
                // 'member' => $member_json_count
            );

        return view('scoreboard.index', compact('issues'));
        }

        
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
