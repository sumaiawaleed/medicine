<?php

namespace App\Http\Middleware;

use App\Models\Client;
use Closure;
use Illuminate\Http\Request;

class ClientApiAuth
{
    public function handle(Request $request, Closure $next)
    {
        if($request->header('Authorization')){
            $client = Client::where('api_token',$request->header('Authorization'))->get()->first();
            if($client)
                return $next($request);
        }
        return abort(403);
    }
}
