<?php

namespace App\Http\Controllers\Dashboard\People;

use App\DataTables\People\UserDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:admins-read'])->only('index', 'show');
        $this->middleware(['permission:admins-create'])->only('create', 'store');
        $this->middleware(['permission:admins-update'])->only('edit', 'update');
        $this->middleware(['permission:admins-delete'])->only('destroy');
    }//end of constructor

    public function index(UserDataTable $dataTable,Request $request){
        $data['title'] = __('site.admins');
        return $dataTable->render('dashboard.people.admins.index',compact('data'));
    }

    private function validate_page($request , $data = "")
    {
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'password' => 'required',
            'type' => 'required',
        ];

        if(!$data){
            $rules +=[
                'image' => 'required',
            ];
        }

        $validator = Validator::make($request->all(), $rules);

        return $validator;

    }

    public function show($id){
        $form_data = User::findOrFail($id);
        if($form_data->type != 1){
            abort(404);
        }
        $data['locations'] = UserLocation::where('user_id',$id)->get();
        return view('dashboard.people.admins.index',compact('data','form_data'));
    }

    public function store(Request $request)
    {
        $validator = $this->validate_page($request);
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
                'password' => bcrypt($request->password),
                'type' => 1,
            ];
            if ($request->image) {
                Image::make($request->image)
                    ->save(public_path('uploads/users/' . $request->image->hashName()));
                $data['image'] = $request->image->hashName();
            }
            User::create($data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function edit($id)
    {
        $form_data = User::findOrFail($id);
        $returnHTML = view('dashboard.people.admins.partials._edit',compact('form_data'))->render();
        return $returnHTML;
    }

    public function update(Request $request,$id)
    {
        $user = User::findOrFail($request->id);
        $validator = $this->validate_page($request,$user);
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
                'password' => bcrypt($request->password),
                'type' => 1,
            ];
            if ($request->image) {
                $path= 'public/uploads/users/'.$user->image;
                if (file_exists($path)) {
                    unlink($path);
                }
                Image::make($request->image)
                    ->save(public_path('uploads/users/' . $request->image->hashName()));
                $data['image'] = $request->image->hashName();
            }
            $user->update($data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function remove($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(array('success' => true));
    }
}
