<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Client\Factory;
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
        $client = new Factory();

        //issue項目の処理

        //パーソナルアクセストークンをつけてAPIを叩くことで1時間のリクエスト制限を5000回に緩和する
        //openしているissueを配列にする
        $open_issue = $client->withToken(env('GITHUB_TOKEN'))->get('https://api.github.com/repos/phase4TeamI/TeamI/issues')->json();

        //closeしているisseuを配列にする
        $close_issue = $client->withToken(env('GITHUB_TOKEN'))->get('https://api.github.com/repos/phase4TeamI/TeamI/issues?state=closed')->json();

        //openしているpullを配列にする
        $open_pull = $client->withToken(env('GITHUB_TOKEN'))->get('https://api.github.com/repos/phase4TeamI/TeamI/pulls')->json();

        //closeしているpullを配列にする
        $close_pull = $client->withToken(env('GITHUB_TOKEN'))->get('https://api.github.com/repos/phase4TeamI/TeamI/pulls?state=close')->json();

        //openしているissueの件数を取得
        $open_issue_count = count($open_issue);
        //closeしているissueの件数を取得
        $close_issue_count = count($close_issue);
        
        //openしているpullの件数を取得
        $open_pull_count = count($open_pull);
        //closeしているpullの件数を取得
        $close_pull_count = count($close_pull);
        
        if ($close_issue === NULL){
            return;
        }else {

            //クローズissueにプルリクエストが含まれているのでプルリクを除く処理
            $new_close_issue = array();

            for($i = 0; $i <= $close_issue_count-1; $i++){
                //pullが含まれる場合はスキップする
                if(strpos($close_issue[$i]["html_url"], 'https://github.com/Phase4TeamI/TeamI/pull/') !== false){
                    //何もしない
                }
                else{
                    $new_close_issue[] = $close_issue[$i];
                }
            }
            // ddd($close_issue);

            $ave_close = 0;
            for($i = 0; $i <= count($new_close_issue)-1; $i++){
                $created_at = new Carbon($new_close_issue[$i]["created_at"]);
                $closed_at = new Carbon($new_close_issue[$i]["closed_at"]);
                $ave_close += $created_at->diffInMinutes($closed_at);
            }
            $ave_close = round((double)$ave_close / 60 / count($new_close_issue), 2);

            $issues[] = array(
                'open'  => $open_issue_count-$open_pull_count,
                'close' => $close_issue_count-$close_pull_count,
                'ave_close'=> $ave_close,
            );
        }

        // ----------------------------

        //プルリク項目の処理
        $ave_merge = 0;
        for($i = 0; $i <= $close_pull_count-1; $i++){
            $created_at = new Carbon($close_pull[$i]["created_at"]);
            $closed_at = new Carbon($close_pull[$i]["closed_at"]);
            $ave_merge += $created_at->diffInMinutes($closed_at);
        }

        $ave_merge = round((double)$ave_merge / 60 / $close_pull_count, 2);
        $pulls[] = array(
            'open'  => $open_pull_count,
            'close' => $close_pull_count,
            'ave_merge'=> $ave_merge,
        );
        
        return view('scoreboard.index', compact('issues', 'pulls'));

        
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
