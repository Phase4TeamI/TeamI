<?php

namespace App\Library;

use App\Models\User;
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
        return $response;
    }

    /*  
     *  概要  DBからユーザーのPull Requestを取得
     *  引数  String リポジトリID (repository.id),  String ユーザーID (users.id)
     *  返値  Array  DBクエリの結果
     */ 
    public static function getUserPull($repository_id, $user_id) {
        $user = User::find($user_id);
        $pulls = Pull::query()
        ->where('repository_id', $repository_id)
        ->where('provider_id', $user->provider_id)
        ->orderBy('id','asc')
        ->get();

        return $pulls;
    }

    /*
        Setter
    */

    /*  
     *  概要  GitHubリポジトリからPull Requestを取得しDBにキャッシュする
     *  引数  String リポジトリID (repository.repository_id)
     *  返値  無し
     */ 
    public static function storePull($repository_id) {
        $repository = Repository::where('repository_id', '=', $repository_id)->first();

        $array = PullCacher::getPullFromRemote($repository->repository_url);

        $replace_target = array("T", "Z");
        $replace_after = array(" ", "");

        $query = array();
        foreach ($array as $arr) {
            $query[] = [
                'repository_id' => $repository->id,
                'number' => $arr["number"],
                'html_url' => $arr["html_url"],
                'title' => $arr["title"],
                'provider_id' => $arr["user"]["id"],
                'closed_at' => isset($arr["closed_at"]) ? str_replace($replace_target, $replace_after, $arr["closed_at"]) : null,
                'merged_at' => isset($arr["merged_at"]) ? str_replace($replace_target, $replace_after, $arr["merged_at"]) : null,
                'created_at' => str_replace($replace_target, $replace_after, $arr["created_at"]),
                'updated_at' => str_replace($replace_target, $replace_after, $arr["updated_at"]),
            ];
        }

        $result = Pull::upsert($query, ['repository_id', 'number'], ['title', 'closed_at', 'merged_at', 'updated_at']);
        return;
    }

}