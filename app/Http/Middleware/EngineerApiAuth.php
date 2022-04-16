<?php

namespace App\Http\Middleware;

use App\Models\Engineer;
use Closure;
use Illuminate\Http\Request;

class EngineerApiAuth
{
    public function handle(Request $request, Closure $next)
    {
        if($request->header('Authorization')){
            $eng = Engineer::where('api_token',$request->header('Authorization'))->get()->first();
            if($eng)
                return $next($request);
        }
        return abort(403);
    }
}
