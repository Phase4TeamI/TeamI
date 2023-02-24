<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function payload(Request $request)
    {
        
        //$payload = mb_convert_encoding($request, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
        //$payload = json_decode($payload, true);

        //if ($payload === NULL){
        //    Log::info("null");
        //}else {
        //    Log::info("exist");
        //}

        Log::info($request["repository"]["html_url"]);
        return;

    }
}
