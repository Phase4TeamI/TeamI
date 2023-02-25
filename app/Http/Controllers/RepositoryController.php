<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Repository;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Log;
use App\Library\WebRequestSender;

class RepositoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $myrepositories = Repository::query()
        ->where('user_id', Auth::id())
        ->orderBy('created_at','desc')
        ->get();
        return view('repository.index', compact('myrepositories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('repository.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // バリデーション
        $validator = Validator::make($request->all(), [
            'name' => 'required | max:255',
            'repository_url' => 'required',
        ]);

        // バリデーションエラー
        if ($validator->fails()) {
            return redirect()->route('repository.create')->withInput()->withErrors($validator);
        }

        //APIにリポジトリを問い合わせ
        $api_uri = "https://api.github.com/repos/" . str_replace("https://github.com/", "", $request->input("repository_url"));

        $response = WebRequestSender::getResponse($api_uri);
        if (!isset($response)) {
            return redirect()->route('repository.create')->withInput();
        }

        // DBに格納
        $request->merge(['user_id' => Auth::user()->id]);
        $request->merge(['repository_id' => $response["id"]]);
        $result = Repository::create($request->all());
        return redirect()->route('repository.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $repository = Repository::find($id);
        return view('repository.show', compact('repository'));
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
        $result = Repository::find($id)->delete();
        return redirect()->route('repository.index');
    }


    public function addUser(Request $request)
    {
        // バリデーション
        $validator = Validator::make($request->all(), [
            'mail' => 'required|email:filter'
        ]);

        $repository = Repository::find($request->input('id'));
        // バリデーションエラー
        if ($validator->fails()) {
            return view('repository.show', compact('repository'));
        }
        
        $getUser = User::where('email', '=', $request->input('mail'))->first();

        $user = User::find($getUser->id);
        $user->repositories()->sync($request->input('id'));

        return view('repository.show', compact('repository'));
    }
}
