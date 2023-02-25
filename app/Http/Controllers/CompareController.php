<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use Illuminate\Http\Client\Factory;
use Carbon\Carbon;

use Illuminate\Http\Request;

class CompareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('compare.index');
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

        
        $client = new Factory();
        //state=allにしているのでイシューとプルリク両方入って帰ってくる
        $compare_1 = $client->withToken(env('GITHUB_TOKEN'))->get('https://api.github.com/repos/anti-15/fronavi/issues?state=all&per_page=100&sort=updated&direction=desc&since='.$firstOfMonth_1.'&until='.$lastOfMonth_1)->json();
        $compare_2 = $client->withToken(env('GITHUB_TOKEN'))->get('https://api.github.com/repos/anti-15/fronavi/issues?state=all&per_page=100&sort=updated&direction=desc&since='.$firstOfMonth_2.'&until='.$lastOfMonth_2)->json();
        

        if ($compare_1 === NULL){
            return;
        }else {

            //イシューとプルリクを分ける作業
            $compare_issue_1 = array();
            $compare_pull_1 = array();

            for($i = 0; $i <= count($compare_1)-1; $i++){
                //pullが含まれる場合はpullの配列に格納する。
                if(strpos($compare_1[$i]["html_url"], 'https://github.com/anti-15/Fronavi/pull') !== false){
                    $compare_pull_1[] = $compare_1[$i];
                }
                //issueの時はissueの配列に格納する
                else{
                    $compare_issue_1[] = $compare_1[$i];
                }
            }

            $new_compare_1[] = array(
                'issue'  => count($compare_issue_1),
                'pull' => count($compare_pull_1)
            );
        }

        if ($compare_2 === NULL){
            return;
        }else {

            //イシューとプルリクを分ける作業
            $compare_issue_2 = array();
            $compare_pull_2 = array();

            for($i = 0; $i <= count($compare_2)-1; $i++){
                //pullが含まれる場合はpullの配列に格納する。
                if(strpos($compare_2[$i]["html_url"], 'https://github.com/anti-15/Fronavi/pull') !== false){
                    $compare_pull_2[] = $compare_2[$i];
                }
                //issueの時はissueの配列に格納する
                else{
                    $compare_issue_2[] = $compare_2[$i];
                }
            }

            $new_compare_2[] = array(
                'issue'  => count($compare_issue_2),
                'pull' => count($compare_pull_2)
            );
        }
        return view('compare.index', compact('new_compare_1', 'new_compare_2'));
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
