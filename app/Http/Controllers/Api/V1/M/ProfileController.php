<?php

namespace App\Http\Controllers\Api\V1\M;

use App\Functions\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function profile(Request $request){
        $apis = new ApiHelper();
        $data['profile'] = $request->user('api');
        $apis->createApiResponse(false, 200, "  ", $data);
        return;
    }

    private function validate_page($request , $data = "")
    {
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ];

        if(!$data){
            $rules +=[
                'image' => 'required',
                'password' => 'required',
            ];
        }

        $validator = Validator::make($request->all(), $rules);

        return $validator;

    }

    public function edit(Request $request)
    {
        $apis = new ApiHelper();
        $user = $request->user('api');
        $validator = $this->validate_page($request,$user);
        $lang = $request->header('lang');
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'type' => 2,
            ];
            if ($request->image) {
                $path= 'public/uploads/users/'.$user->image;
                if ($user->image and file_exists($path)) {
                    unlink($path);
                }
                Image::make($request->image)
                    ->save(public_path('uploads/users/' . $request->image->hashName()));
                $data['image'] = $request->image->hashName();
            }
            $user->update($data);
            $role = Role::find(3);
            if ($role)
                $user->syncRoles([$role->name]);
            $apis->createApiResponse(false, 200, __('api.' . $lang . '.updated_done'), "");
        }
    }

    public function permissions(Request $request){
        $apis = new ApiHelper();
        $data['permissions'] = $request->user('api')->allPermissions();
        $apis->createApiResponse(false, 200, "  ", $data);
        return;
    }
}
