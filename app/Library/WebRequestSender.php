<?php

namespace App\Library;

use Illuminate\Support\Facades\Log;

class WebRequestSender {

    /*  
     *  概要  引数のURLからレスポンスを受け取る
     *  引数  String URL
     *  返値  Array  レスポンス
     */ 
    public static function getResponse($uri) {

        $context = stream_context_create(array(
            'http' => array(
                'method' => 'GET',
                'header' => 'User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; Touch; rv:11.0) like Gecko'
                )
            )
        );
        
        //200 以外はNullを返す
        if($response = @file_get_contents($uri, false, $context)) {
            $response = json_decode($response,true);
            return $response;
        
        } else {
            return null;
        }
        
    }
}