<?php

namespace App\Library;

use App\Models\Issue;
use App\Models\Repository;

use Illuminate\Support\Facades\Log;

class IssueCacher {

    /*
        Getter
    */

    /*  
     *  概要  GitHubリポジトリから全てのIssueを取得
     *  引数  String リポジトリURL
     *  返値  Array  レスポンス
     */ 
    public static function getIssueFromRemote($repository_url) {
        $api_uri = "https://api.github.com/repos/" . str_replace("https://github.com/", "", $repository_url) . "/issues?state=all";
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
     *  概要  DBから全てのIssueを取得
     *  引数  String リポジトリID (repository.id)
     *  返値  Array  DBクエリの結果
     */ 
    public static function getIssue($repository_id) {
        $issues = Issue::query()
        ->where('repository_id', $repository_id)
        ->orderBy('id','asc')
        ->get();

        return $issues;
    }

    /*  
     *  概要  DBからユーザーのIssueを取得
     *  引数  String リポジトリID (repository.id),  String ユーザーID (users.id)
     *  返値  Array  DBクエリの結果
     */ 
    public static function getUserIssue($repository_id, $user_id) {
        $user = User::find($user_id);
        $issues = Issue::query()
        ->where('repository_id', $repository_id)
        ->where('provider_id', $user->provider_id)
        ->orderBy('id','asc')
        ->get();

        return $issues;
    }

    /*  
     *  概要  DBからユーザーのクローズされたIssueを取得
     *  引数  String リポジトリID (repository.id),  String ユーザーID (users.id)
     *  返値  Array  DBクエリの結果
     */ 
    public static function getUserClosedIssue($repository_id, $user_id) {
        $user = User::find($user_id);
        $issues = Issue::query()
        ->where('repository_id', $repository_id)
        ->where('provider_id', $user->provider_id)
        ->whereNotNull('closed_at')
        ->orderBy('id','asc')
        ->get();

        return $issues;
    }

    /*
        Setter
    */

    /*  
     *  概要  GitHubリポジトリからIssueを取得しDBにキャッシュする
     *  引数  String リポジトリID (repository.repository_id)
     *  返値  無し
     */ 
    public static function storeIssue($repository_id) {
        $repository = Repository::where('repository_id', '=', $repository_id)->first();

        $array = IssueCacher::getIssueFromRemote($repository->repository_url);

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
                'created_at' => str_replace($replace_target, $replace_after, $arr["created_at"]),
                'updated_at' => str_replace($replace_target, $replace_after, $arr["updated_at"]),
            ];
        }

        $result = Issue::upsert($query, ['repository_id', 'number'], ['title', 'closed_at', 'created_at']);
        return;
    }
}