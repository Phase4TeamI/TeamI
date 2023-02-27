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

    public static function getUserMonthlyScore($repository_id, $user_id) {
        $score = Score::query()
        ->whereDate('updated_at', date("Y-m-d"))
        ->where('repository_id', $repository_id)
        ->where('user_id', $user_id)
        ->orderBy('updated_at','desc')
        ->first();

        return $score->score;
    }

    public static function getUserScores($repository_id, $user_id) {
        $score = Score::query()
        ->selectRaw('date_format(updated_at, "%Y-%m") as day')
        ->selectRaw('MAX(score) as score')
        ->where('repository_id', $repository_id)
        ->where('user_id', $user_id)
        ->groupBy('day')
        ->orderBy('day', 'desc')
        ->get()->toArray();
        return $score;
    }

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

        $score = ScoreManager::calcScore($issueClosed, $issueClosedAverage, $commit, $pullRequestMerged);

        //今日のデータが既に格納されているかチェック
        $isExistScore = Score::query()
        ->whereDate('created_at', date("Y-m-d"))
        ->where('repository_id', $repository_id)
        ->where('user_id', $user_id)
        ->get()->toArray();

        if(empty($isExistScore)) {
            $result = Score::create([
                "repository_id" => $repository_id,
                "user_id" => $user_id,
                "score" => $score,
            ]);
        } else {
            $result = Score::query()
            ->whereDate('created_at', date("Y-m-d"))
            ->where('repository_id', $repository_id)
            ->where('user_id', $user_id)
            ->update([
                "score" => $score,
            ]);
        }

        return;
    }
}