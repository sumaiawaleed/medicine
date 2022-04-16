<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:users-read'])->only('index', 'show');
        $this->middleware(['permission:users-create'])->only('create', 'store');
        $this->middleware(['permission:users-update'])->only('edit', 'update');
        $this->middleware(['permission:users-delete'])->only('destroy');
    }//end of constructor

    private function validate_page($request,$user = null){
        $rules = [
            'name' => 'required',
        ];

        if($user){
            $rules += ['email' => [ 'required','email',
                Rule::unique('users')->ignore($user->id, 'id')
            ]
            ];
        }else{
            $rules += ['email' => [ 'required','email','unique:users' ],
                'password' => 'required|min:6|confirmed'
            ];
        }

        $validator = Validator::make($request->all(), $rules);

        return $validator;

    }
    public function index(UserDataTable $dataTable,Request $request){
        $data['title'] = __('site.users');
        return $dataTable->render('dashboard.users.index', compact('data','request'));
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
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['password'] = bcrypt($request->password);
            if ($request->image) {

                Image::make($request->image)
                    ->save(public_path('uploads/users/' . $request->image->hashName()));

                $data['image'] = $request->image->hashName();

            }//end of if
            $user = User::create($data);
            $role = Role::find(1);
            if ($role)
                $user->syncRoles([$role->name]);
            return response()->json(array('success' => true), 200);
        }

    }

    public function edit($id)
    {
        $form_data = User::findOrFail($id);
        $returnHTML = view('dashboard.users.partials._edit',compact('form_data'))->render();
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
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $user->update($data);

            return response()->json(array('success' => true), 200);
        }
    }

    public function remove($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json(array('success' => true), 200);
    }
}
