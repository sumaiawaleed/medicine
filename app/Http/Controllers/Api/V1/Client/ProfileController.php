<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Functions\ApiHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profile(Request $request){
        $apis = new ApiHelper();
        $data['profile'] = $request->user('api');

        $apis->createApiResponse(false, 200, "  ", $data);
        return;
    }
}
