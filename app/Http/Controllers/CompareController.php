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
        // ここから
        $year1 = $request->input('year1');
        $month1 = $request->input('month1');

        // ここまで
        $year2 = $request->input('year2');
        $month2 = $request->input('month2');

        $from1 = Carbon::create($year1, $month1, 1)->firstOfMonth();
        $to1 = Carbon::create($year1, $month1, 1)->lastOfMonth();

        // ddd($from1);

        $client = new Factory();
        $open_issue = $client->withToken(env('GITHUB_TOKEN'))->get('https://api.github.com/repos/phase4TeamI/TeamI/issues?state=all&per_page=100&sort=updated&direction=desc&since='.$from1.'&until='.$to1)->json();
        ddd($open_issue);
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
