<?php

namespace App\Http\Controllers\Dashboard\People;

use App\DataTables\People\RoleDataTable;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:roles-read'])->only('index', 'show');
        $this->middleware(['permission:roles-create'])->only('create', 'store');
        $this->middleware(['permission:roles-update'])->only('edit', 'update');
        $this->middleware(['permission:roles-delete'])->only('destroy');
    }//end of constructor

    private function validate_page($request,$role = null){
        $rules = [
            'display_name' => 'required',
        ];

        if($role){
            $rules += ['name' => [ 'required',
                Rule::unique('roles')->ignore($role->id, 'id')
            ]
            ];
        }else{
            $rules += ['name' => [ 'required','unique:roles' ],
            ];
        }

        $validator = Validator::make($request->all(), $rules);

        return $validator;

    }
    public function index(RoleDataTable $dataTable,Request $request){
        $data['title'] = __('site.roles');
        $data['url'] = route(env('DASH_URL') . '.roles.index');
        return $dataTable->render('dashboard.roles.index', compact('data','request'));
    }

    public function create()
    {
        $data['title'] = __('site.add').' '.__('site.one_roles');
        $data['url'] = route(env('DASH_URL') . '.roles.store');
        return view('dashboard.people.roles.create', compact('data'));
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
            $data['display_name'] = $request->display_name;
            $data['description'] = $request->description;
            $role = Role::create($data);
            $role->syncPermissions($request->permissions);
            return response()->json(array('success' => true), 200);
        }

    }

    public function edit($id)
    {
        $form_data = Role::find($id);
        $data['title'] = __('site.edit').' '.__('site.one_roles');
        $data['url'] = route(env('DASH_URL') . '.roles.update',$form_data->id);
        return view('dashboard.people.roles.edit', compact('data','form_data'));
    }

    public function update(Request $request,$id)
    {
        $role = Role::find($id);
        $validator = $this->validate_page($request,$role);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {
            $data['name'] = $request->name;
            $data['display_name'] = $request->display_name;
            $data['description'] = $request->description;
            $role->syncPermissions($request->permissions);
            $role->update($data);

            return response()->json(array('success' => true), 200);
        }
    }

    public function destroy($id)
    {
        $role = Role::find($id);
        $role->update(['is_delete' => 1]);
        return redirect()->back();
    }
}
