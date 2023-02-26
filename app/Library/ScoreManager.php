<?php

namespace App\Library;

use App\Models\Score;
use App\Models\Repository;
use App\Models\Commit;
use App\Models\Issue;
use App\Models\Pull;
use App\Models\User;

use App\Library\IssueCacher;
use App\Library\PullCacher;
use App\Library\CommitCacher;

use Illuminate\Support\Facades\Log;

class ScoreManager {

    public static function calcScore($issueClosed, $issueClosedAverage, $commit, $pullRequestMerged) {
        return floor($issueClosedAverage / (($issueClosed + $commit) * $pullRequestMerged));
    }


    //指定した年月の下記値を取得する
    //$issueClosed        Issueのクローズ数
    //$issueClosedAverage Issueの平均クローズ時間
    //$pullRequestMerged  プルリクエストのマージ数
    //$commit             コミット数
    public static function storeScore($repository_id, $user_id, $year, $month) {

        $user = User::find($user_id);

        //1か月のコミット数
        $commit = Commit::query()
        ->whereYear('committed_at', $year)
        ->whereMonth('committed_at', $month)
        ->where('repository_id', $repository_id)
        ->where('provider_id', $user->provider_id)
        ->orderBy('id','asc')
        ->get()->count();


        //1か月のIssueのクローズ数
        $issues = Issue::query()
        ->whereYear('closed_at', $year)
        ->whereMonth('closed_at', $month)
        ->where('repository_id', $repository_id)
        ->where('provider_id', $user->provider_id)
        ->whereNotNull('closed_at')
        ->orderBy('id','asc')
        ->get()->toArray();
        $issueClosed = count($issues);


        //1か月のIssueの平均クローズ時間
        $calcAverage = [];
        foreach($issues as $issue) {
            $calcAverage[] = strtotime($issue["closed_at"]) - strtotime($issue["created_at"]);
        }
        $issueClosedAverage = floor(array_sum($calcAverage) / count($calcAverage));

        
        //1か月のプルリクエストのマージ数
        $pullRequestMerged = Pull::query()
        ->whereYear('closed_at', $year)
        ->whereMonth('closed_at', $month)
        ->where('repository_id', $repository_id)
        ->where('provider_id', $user->provider_id)
        ->whereNotNull('merged_at')
        ->orderBy('id','asc')
        ->get()->count();

        Log::info("Commit:".$commit);
        Log::info("IssueClosed:".$issueClosed);
        Log::info("IssueClosedAverage:".$issueClosedAverage);
        Log::info("PullRequestMerged:".$pullRequestMerged);
        return;

        $score = ScoreManager::calcScore($issueClosed, $issueClosedAverage, $commit, $pullRequestMerged)
        $result = Repository::create([
            "user_id" => $user_id,
            "score" => $score,
        ]);
    }
}