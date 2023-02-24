<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

use App\Library\WebRequestSender;
use App\Library\IssueCacher;

use App\Models\Repository;

class WebhookController extends Controller
{
    public function payload(Request $request)
    {

        $repository = Repository::where('repository_id', '=', $request["repository"]['id'])->first();
        if(isset($repository)) {
            IssueCacher::storeIssue($request["repository"]['id']);
        }

        return;

    }
}
