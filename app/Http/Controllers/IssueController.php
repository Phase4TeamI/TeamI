<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IssueController extends Controller
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
        $url = "https://api.github.com/repos/phase4TeamI/TeamI/issues?client_id=cd45cfb92a22d036f94b&";

        //JSONデータを全て文字列に読み込むためにjsonという変数を作製
        $json = file_get_contents($url, false, $ctx);

        //文字化け対策
        $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
        
        //第二引数にtrueを使用することで連想配列にすることができる
        $ary = json_decode($json,true);

        // ddd($ary);
        //各データを格納する処理
        if ($ary === NULL){
            return;
        }else {
            $json_count = count($ary);

            //各パラメータを配列にする準備
            $titles = array();
            $label = array();
            $url = array();
            $users = array();

            //最終的にissue.indexに送る変数
            $results = array();

            //各パラメータの配列に格納
            for($i = 0; $i <= $json_count-1; $i++){
                $users[] = $ary[$i]["user"]["login"];
                $titles[] = $ary[$i]["title"];
                
            }
            // $results = array($user,$titles);

            
            for($i = 0; $i <= $json_count-1; $i++){
                $results[$i] = array(
                    'user' => $users[$i],
                    'title' => $titles[$i]
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
