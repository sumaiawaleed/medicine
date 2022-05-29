<?php

namespace App\Http\Controllers\Api\V1;

use App\Functions\ApiHelper;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request){
        $rules = [
            'email' => 'required|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errors = $validator->getMessageBag()->toArray();
            $apis = new ApiHelper();
            $apis->createApiResponse(true, 200, "validation error", $errors);
            return;

        }
        else{
            $credentials1 = (['email' => $request->email,
                'password' => $request->password]);

            if (!(Auth::attempt($credentials1))) {
                $apis = new ApiHelper();
                $apis->createApiResponse(true, 200, "بيانات الدخول غير صحيحة", "");
                return;
            }
            $user = $request->user();
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            if ($request->remember_me)
                $token->expires_at = Carbon::now()->addWeeks(1);
            $token->save();
            $result_array = [
                'access_token' => 'Bearer '.$tokenResult->accessToken,
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString(),
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'image_path' => $user->image_path,
                'type' => $user->type,
                'permissions'=> $user->allPermissions()
            ];

            $apis = new ApiHelper();
            $apis->createApiResponse(false, 200, "  ", $result_array);
            return;
        }
    }
}
