<?php

namespace App\Http\Controllers\Dashboard\People;

use App\DataTables\People\ClientDataTable;
use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ClientType;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Role;
use App\Models\Subscribe;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:clients-read'])->only('index', 'show');
        $this->middleware(['permission:clients-create'])->only('create', 'store');
        $this->middleware(['permission:clients-update'])->only('edit', 'update');
        $this->middleware(['permission:clients-delete'])->only('destroy');
    }//end of constructor

    private function validate_page($request, $user = null)
    {
        $rules = [
            'name' => 'required',
            'client_type' => 'required',
        ];

        if ($user) {
            $rules += ['email' => ['required', 'email',
                Rule::unique('users')->ignore($user->id, 'id')
            ],
                'phone' => ['required',
                    Rule::unique('users')->ignore($user->id, 'id')
                ]
            ];
        } else {
            $rules += ['email' => ['required', 'email', 'unique:users'],
                'password' => 'required|min:6|confirmed',
                'phone' => ['required', 'unique:users']
            ];
        }

        $validator = Validator::make($request->all(), $rules);

        return $validator;

    }

    public function index(ClientDataTable $dataTable, Request $request)
    {
        $data['title'] = __('site.clients');
        $data['types'] = ClientType::all();
        $data['subscribes'] = Subscribe::all();
        return $dataTable->render('dashboard.people.clients.index', compact('data', 'request'));
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
            $data['phone'] = $request->phone;
            $data['type'] = 3;
            $data['password'] = bcrypt($request->password);
            if ($request->image) {

                Image::make($request->image)
                    ->save(public_path('uploads/users/' . $request->image->hashName()));

                $data['image'] = $request->image->hashName();

            }//end of if
            $user = User::create($data);
            if ($user) {
                Client::create([
                    'user_id' => $user->id,
                    'type_id' => $request->client_type,
                    'company_name' => $request->company_name,
                    'subscribe_id' => $request->subscribe_id,
                    'subscribe_date' => now(),
                    'subscribe_status' => 1,
                ]);
            }
            $role = Role::find(2);
            if ($role)
                $user->syncRoles([$role->name]);
            return response()->json(array('success' => true), 200);
        }

    }

    public function edit($id)
    {
        $form_data = User::findOrFail($id);
        if ($form_data->type != 3) {
            abort(404);
        }
        $data['types'] = ClientType::all();
        $data['client'] = Client::where('user_id', $id)->first();
        $returnHTML = view('dashboard.people.clients.partials._edit', compact('form_data', 'data'))->render();
        return $returnHTML;
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($request->id);
        if ($user->type != 3) {
            abort(404);
        }
        $validator = $this->validate_page($request, $user);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['phone'] = $request->phone;
            if ($request->image) {
                $path = 'public/uploads/users/' . $user->image;
                if ($user->image and file_exists($path)) {
                    unlink($path);
                }
                Image::make($request->image)
                    ->save(public_path('uploads/users/' . $request->image->hashName()));

                $data['image'] = $request->image->hashName();

            }//end of if
            $user->update($data);
            if ($user) {
                $client = Client::where('user_id', $user->id)->first();
                if ($client) {
                    $client->update([
                        'type_id' => $request->client_type,
                        'company_name' => $request->company_name
                    ]);
                }
            }
            $role = Role::find(2);
            if ($role)
                $user->syncRoles([$role->name]);
            return response()->json(array('success' => true), 200);
        }

    }

    public function remove($id)
    {
        $user = User::find($id);
        Client::where('user_id', $id)->delete();
        $user->delete();
        return response()->json(array('success' => true), 200);
    }

    public function show($id)
    {
        $form_data = User::findOrFail($id);
        if ($form_data->type != 3) {
            abort(404);
        }
        $data['page'] = 'edit';
        $data['types'] = ClientType::all();
        $data['title'] = $form_data->name . ' ' . __('site.profile');
        $data['user'] = $form_data;
        $data['client'] = Client::where('user_id', $id)->first();
        $data['orders'] = Order::where('client_id', $id)->count();
        $data['tasks'] = Task::where('client_id', $id)->count();
        $data['invoices'] = Invoice::where('client_id', $id)->count();
        return view('dashboard.people.clients.show', compact('data', 'form_data'));
    }

}
