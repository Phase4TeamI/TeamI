<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use Illuminate\Http\Client\Factory;
use Carbon\Carbon;
use App\Library\IssueCacher;

use Illuminate\Http\Request;

use App\Models\User;
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

        $new_compare_1[] = array(
            'issue' => 0,
            'pull' => 0,
            'commit' => 0,
        );
        
        $new_compare_2[] = array(
            'issue' => 0,
            'pull' => 0,
            'commit' => 0
        );

        return view('compare.index', compact('labels', 'new_compare_1','new_compare_2'));
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

        // $client = new Factory();
        // //state=allにしているのでイシューとプルリク両方入って帰ってくる
        // $compare_1 = $client->withToken(env('GITHUB_TOKEN'))->get('https://api.github.com/repos/anti-15/fronavi/issues?state=all&per_page=100&sort=updated&direction=desc&since='.$firstOfMonth_1.'&until='.$lastOfMonth_1)->json();
        // $compare_2 = $client->withToken(env('GITHUB_TOKEN'))->get('https://api.github.com/repos/anti-15/fronavi/issues?state=all&per_page=100&sort=updated&direction=desc&since='.$firstOfMonth_2.'&until='.$lastOfMonth_2)->json();
        

        //最終的に格納する配列
        $new_compare_issue_1 = array();

        //比較1の年月だけ求める 例：2022-02
        $data_1 = substr($firstOfMonth_1, 0, 7);

        //全てのイシューを取得する
        $OpenedIssues_1 = IssueCacher::getIssue(1);

        $new_OpenedIssues_1 = array();
        //比較1の年月のclosed issueを配列に入れる
        foreach($OpenedIssues_1 as $OI_1){

            //比較1の年月が含まれる場合は処理する
                if(strstr($OI_1->created_at, $data_1) !== false){
                    $new_OpenedIssues_1[] = $OI_1;
                }
                else{
                    //何もしない
                }
        }


        //クローズされたイシューを全件取得する
        $ClosedIssues_1 = IssueCacher::getClosedIssue(1);
        

        $new_ClosedIssues_1 = array();
        //比較1の年月のclosed issueを配列に入れる
        foreach($ClosedIssues_1 as $CI_1){

            //比較1の年月が含まれる場合は処理する
                if(strstr($CI_1->closed_at, $data_1) !== false){
                    $new_ClosedIssues_1[] = $CI_1;
                }
                else{
                    //何もしない
                }
        }

        //クローズされたissueがなかったら(配列の中身が空だったら)0を代入する
        if(empty($new_ClosedIssues_1)){
            $new_compare_issue_1[] = array(
                'opened_issue'  => 0,
                'closed_issue'  => 0,
                'ave_closed' => 0
            );
        }
        //クローズされたissueがあれば配列に追加する
        else{
            $ave_closed_1 = 0;
            foreach($new_ClosedIssues_1 as $new_CI_1){
                $created_at = new Carbon($new_CI_1->created_at);
                $closed_at = new Carbon($new_CI_1->closed_at);
                $ave_closed_1 += $created_at->diffInMinutes($closed_at);
            }
            $ave_closed_1 = round((double)$ave_closed_1 / 60 / count($new_ClosedIssues_1), 2);
            //配列に代入する
            $new_compare_issue_1[] = array(
                'opened_issue'  => count($new_OpenedIssues_1),
                'closed_issue'  => count($new_ClosedIssues_1),
                'ave_closed' => $ave_closed_1
            );
        }

        // ddd($new_compare_issue_1);


        return view('compare.index', compact('labels','new_compare_issue_1'));
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
