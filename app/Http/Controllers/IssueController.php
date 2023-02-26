<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Client\Factory;
use Carbon\Carbon;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $client = new Factory();
        $response = $client->withToken(env('GITHUB_TOKEN'))->get('https://api.github.com/repos/phase4TeamI/TeamI/issues');
        $ary = $response->json();
        
        //各データを格納する処理
        if ($ary === NULL){
            return;
        }else {
            //issueの件数を取得
            $json_count = count($ary);

            //各パラメータを配列にする準備
            $titles = array();
            $label = array();
            $url = array();
            $users = array();
            $issue_open = array();
            //最終的にissue.indexに送る変数
            $results = array();

            //現在時刻をCarbonライブラリで取得し$nowに代入する
            $now = new Carbon();

            //各パラメータの配列に格納
            for($i = 0; $i <= $json_count-1; $i++){

                //アサインされているかどうかを調べる
                //アサインされていなかったら'null'を代入
                if(empty($ary[$i]["assignee"]["login"])){
                    $users[] = 'null';
                }
                //アサインされていたらユーザーネームを代入
                else{
                    $users[] = $ary[$i]["assignee"]["login"];
                }

                //タイトルを代入
                $titles[] = $ary[$i]["title"];

                //'現在時刻'-'issueが作られた時間'でissueがopenしてからの時間を取得
                $issue_open[] = new Carbon($ary[$i]["created_at"]);
                //時間差を代入
                //何日と何時間経過したか
                $day[] = $issue_open[$i]->diffInDays($now);
                $hour[] = ($issue_open[$i]->diffInHours($now)) % 24;
            }

            //issue.indexに渡す為の連想配列をさ作成する
            for($i = 0; $i <= $json_count-1; $i++){
                $results[$i] = array(
                    'user'  => $users[$i],
                    'title' => $titles[$i],
                    'day'  => $day[$i],
                    'hour' => $hour[$i]
                );
                
            }
            // ddd($results);
            return view('issue.index',compact('results'));
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
