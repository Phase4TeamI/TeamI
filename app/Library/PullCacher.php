<?php

namespace App\Library;

use App\Models\Pull;
use App\Models\Repository;

use Illuminate\Support\Facades\Log;

class PullCacher {

    /*
        Getter
    */

    /*  
     *  概要  GitHubリポジトリから全てのPull Requestを取得
     *  引数  String リポジトリURL
     *  返値  Array  レスポンス
     */ 
    public static function getPullFromRemote($repository_url) {
        $api_uri = "https://api.github.com/repos/" . str_replace("https://github.com/", "", $repository_url) . "/pulls?state=all";
        $response = WebRequestSender::getResponse($api_uri);

        if (!isset($response)) {
            return [];
        }

        $issue = array();
        foreach ($response as $rep) {
            if(!array_key_exists("pull_request", $rep)) {
                $issue[] = $rep;
            }
        }
        return $issue;
    }

    /*
        Setter
    */

}