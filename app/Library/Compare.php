<?php

namespace App\Library;

use App\Models\Issue;
use App\Models\Repository;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class Compare {



    /*  
     *  概要  日付データから年と月のみを抽出する
     *  引数  String  年  String  月
     *  返値  String  例:2020-2
     */ 
    public static function subDay($year, $month) {
        $firstOfMonth = Carbon::create($year, $month, 1)->firstOfMonth();

        $data = substr($firstOfMonth, 0, 7);
        return $data;
    }

    /*  
     *  概要  入力された年と月にオープンされたIssueやプルリクエストを取ってくる
     *  引数  Array  全ての期間でオープンした全てのissue  String  subDayで取得したデータ(その年月が含まれるかどうかを判断するため)
     *  返値  Array  その年、月にオープンした全ての配列
     */ 
    public static function getOpened($fullOpened, $data){

        $OpenedIssueOrPull = array();
        foreach($fullOpened as $opened){
            
            //入力した年月が含まれる場合は処理する
            if(strstr($opened->created_at, $data) !== false){
                $OpenedIssueOrPull[] = $opened;
            }
            else{
                //何もしない
            }
        }
        return $OpenedIssueOrPull;
    }

    /*  
     *  概要  入力された年と月にクローズされたIssueやプルリクエストを取ってくる
     *  引数  Array  全ての期間でクローズした全てのissue  String  subDayで取得したデータ(その年月が含まれるかどうかを判断するため)
     *  返値  Array  その年、月にオープンした全ての配列
     */ 
    public static function getClosed($fullClosed, $data){

        $ClosedIssueOrPull = array();
        foreach($fullClosed as $closed){
            
            //入力した年月が含まれる場合は処理する
            if(strstr($closed->closed_at, $data) !== false){
                $ClosedIssueOrPull[] = $closed;
            }
            else{
                //何もしない
            }
        }
        return $ClosedIssueOrPull;
    }

    /*  
     *  概要  クローズされたissueの配列を受け取って平均クローズ時間をカウントし、最終的にviewに渡すための配列を作成する
     *  引数  Array  期間中にクローズした全てのissue  Array  期間中にオープンした全てのissue
     *  返値  Array  平均クローズ時間を含めた、issueの情報が入った配列
     */ 
    public static function averageCloseIssue($new_ClosedIssues, $new_OpenedIssues){

        //クローズされたissueがない場合0を代入する
        if(empty($new_ClosedIssues)){
            $new_compare_issue[] = array(
                'opened_issue'  => 0,
                'closed_issue'  => 0,
                'ave_closed' => 0
            );
        }
        //クローズされたissueがあれば配列に追加する
        else{
            $ave_closed = 0;
            foreach($new_ClosedIssues as $closed){
                $created_at = new Carbon($closed->created_at);
                $closed_at = new Carbon($closed->closed_at);
                $ave_closed += $created_at->diffInMinutes($closed_at);
            }
            $ave_closed = round((double)$ave_closed / 60 / count($new_ClosedIssues), 2);
            //配列に代入する
            $new_compare_issue[] = array(
                'opened_issue'  => count($new_OpenedIssues),
                'closed_issue'  => count($new_ClosedIssues),
                'ave_closed' => $ave_closed
            );
        }
        return $new_compare_issue;
    }
}