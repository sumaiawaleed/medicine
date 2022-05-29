<?php

namespace App\Http\Controllers\Api\V1\M;

use App\Functions\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request){
        $apis = new ApiHelper();
        $user = $request->user('api');
        $lang = $request->header('lang');
        if($user){
            $data['tasks'] = Task::with(['location'])
                ->where('sales_person_id',$user->id)
                ->orderByDesc('id')
                ->paginate(20);

            foreach ($data['tasks'] as $index=>$task){
                $task->status_name  = __('api.'.$lang.'.tasks.'.$task->status);
                $task->client_name  = $task->getClient() ? $task->getClient()->name  : '';
            }
            $apis->createApiResponse(false, 200, "  ", $data);
            return;
        }else{
            abort(404);
        }
    }

}
