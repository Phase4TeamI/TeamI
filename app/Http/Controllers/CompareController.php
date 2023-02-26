<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use Illuminate\Http\Client\Factory;
use Carbon\Carbon;
use App\Library\IssueCacher;
use App\Library\Compare;

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

        $new_compare_issue_1[] = array(
                'opened_issue'  => 0,
                'closed_issue'  => 0,
                'ave_closed' => 0
            );
        
        $new_compare_2[] = array(
            'issue' => 0,
            'pull' => 0,
            'commit' => 0
        );

        return view('compare.index', compact('labels', 'new_compare_issue_1','new_compare_2'));
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
        $new_compare_issue_1 = array();
        $new_compare_issue_1 = Compare::averageCloseIssue($new_ClosedIssues_1, $new_OpenedIssues_1);


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
