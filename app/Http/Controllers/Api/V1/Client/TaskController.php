<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Functions\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request){
        $apis = new ApiHelper();
        $user = $request->user('api');
        $lang = $request->header('lang');
        $client = Client::where('user_id',$user->id)->first();
        if($client){
            $data['tasks'] = Task::with(['employee','location'])
                ->where('client_id',$client->id)
                ->orderByDesc('id')
                ->paginate(20);

            foreach ($data['tasks'] as $index=>$task){
                $task->status_name  = __('api.'.$lang.'.tasks.'.$task->status);
            }
            $apis->createApiResponse(false, 200, "  ", $data);
            return;
        }else{
            abort(404);
        }
    }
}
