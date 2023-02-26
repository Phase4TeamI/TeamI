<?php

namespace App\Library;

use App\Models\User;
use App\Models\Commit;
use App\Models\Repository;

use Illuminate\Support\Facades\Log;

class CommitCacher {

    /*
        Getter
    */

    /*  
     *  概要  GitHubリポジトリから全てのCommitを取得
     *  引数  String リポジトリURL
     *  返値  Array  レスポンス
     */ 
    public static function getCommitFromRemote($repository_url) {
        $api_uri = "https://api.github.com/repos/" . str_replace("https://github.com/", "", $repository_url) . "/commits?state=all";
        $response = WebRequestSender::getResponse($api_uri);

        if (!isset($response)) {
            return [];
        }
        return $response;
    }

    /*  
     *  概要  DBからユーザーのCommitを取得
     *  引数  String リポジトリID (repository.id),  String ユーザーID (users.id)
     *  返値  Array  DBクエリの結果
     */ 
    public static function getUserCommit($repository_id, $user_id) {
        $user = User::find($user_id);
        $commits = Commit::query()
        ->where('repository_id', $repository_id)
        ->where('provider_id', $user->provider_id)
        ->orderBy('id','asc')
        ->get();

        return $commits;
    }

    /*
        Setter
    */

    /*  
     *  概要  GitHubリポジトリからCommitを取得しDBにキャッシュする
     *  引数  String リポジトリID (repository.repository_id)
     *  返値  無し
     */ 
    public static function storeCommit($repository_id) {
        $repository = Repository::where('repository_id', '=', $repository_id)->first();

        $array = CommitCacher::getCommitFromRemote($repository->repository_url);

        $replace_target = array("T", "Z");
        $replace_after = array(" ", "");

        $query = array();
        foreach ($array as $arr) {
            $query[] = [
                'repository_id' => $repository->id,
                'sha' => $arr["sha"],
                'html_url' => $arr["html_url"],
                'message' => $arr["commit"]["message"],
                'provider_id' => $arr["author"]["id"],
                'committed_at' => str_replace($replace_target, $replace_after, $arr["commit"]["author"]["date"]),
            ];
        }

        $result = Commit::upsert($query, ['repository_id', 'sha'], ['message', 'committed_at']);
        return;
    }

}