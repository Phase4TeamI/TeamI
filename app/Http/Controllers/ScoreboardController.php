<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $issue_url = "https://api.github.com/repos/phase4TeamI/TeamI/issues";
        //pull requestのURL
        $pull_url = "https://api.github.com/repos/phase4TeamI/TeamI/pulls";
        //commit
        $commit_url = "https://api.github.com/repos/phase4TeamI/TeamI/commits";
        //members
        $member_url = "https://api.github.com/orgs/Phase4TeamI/members";

        //JSONデータを全て文字列に読み込むためにjsonという変数を作製
        $issue_json = file_get_contents($issue_url, false, $ctx);
        $pull_json = file_get_contents($pull_url, false, $ctx);
        $commit_json = file_get_contents($commit_url, false, $ctx);
        $member_json = file_get_contents($member_url, false, $ctx);

        //文字化け対策
        $issue_json = mb_convert_encoding($issue_json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
        $pull_json = mb_convert_encoding($pull_json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
        $commit_json = mb_convert_encoding($commit_json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
        $member_json = mb_convert_encoding($member_json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
        
        //第二引数にtrueを使用することで連想配列にすることができる
        $issue_ary = json_decode($issue_json,true);
        $pull_ary = json_decode($pull_json,true);
        $commit_ary = json_decode($commit_json,true);
        $member_ary = json_decode($member_json,true);

        $issue_json_count = count($issue_ary);
        $pull_json_count = count($pull_ary);
        $commit_json_count = count($commit_ary);
        $member_json_count = count($member_ary);
        

        return view('scoreboard.index', compact('issue_json_count'));
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
