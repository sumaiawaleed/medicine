<?php

namespace App\Http\Controllers\Api\V1\Emp;

use App\Functions\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Client;
use App\Models\ClientType;
use App\Models\Role;
use App\Models\User;
use App\Models\UserLocation;
use Cassandra\Type\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

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
                'password' => 'required|min:6',
                'phone' => ['required', 'unique:users']
            ];
        }

        $validator = Validator::make($request->all(), $rules);

        return $validator;

    }

    public function index(Request $request)
    {
        $apis = new ApiHelper();
        $lang = $request->header('lang');
        $user = $request->user();

        $clients = User::with(['client'])->whereHas('locations', function ($query) use ($request) {
            if ($request->city_id != 0) {
                $query->where('city_id', $request->city_id);
            }
            if ($request->area_id != 0) {
                $query->where('area_id', $request->area_id);
            }
        })->orderByDesc('id')
            ->where('type', 3)->paginate(20);
        $data['clients'] = array();
        foreach ($clients as $index => $client) {
            if ($client->client) {
                $data['clients'][$index]['id'] = $client->client->id;
                $data['clients'][$index]['name'] = $client->name;
                $data['clients'][$index]['type'] = $client->client->type_name;
            }
        }
        $apis->createApiResponse(false, 200, "  ", $data);
        return;
    }

    public function all_clients(Request $request)
    {
        $apis = new ApiHelper();
        $lang = $request->header('lang');
        $user = $request->user();

        $clients = User::with(['client'])->whereHas('locations', function ($query) use ($request) {
            if ($request->city_id != 0) {
                $query->where('city_id', $request->city_id);
            }
            if ($request->area_id != 0) {
                $query->where('area_id', $request->area_id);
            }
        })->orderByDesc('id')
            ->where('type', 3)->get();
        $data['clients'] = array();
        foreach ($clients as $index => $client) {
            if ($client->client) {
                $data['clients'][$index]['id'] = $client->client->id;
                $data['clients'][$index]['name'] = $client->name;
                $data['clients'][$index]['type'] = $client->client->type_name;
            }
        }
        $apis->createApiResponse(false, 200, "  ", $data);
        return;
    }

    public function show($id, Request $request)
    {
        $apis = new ApiHelper();
        $lang = $request->header('lang');
        $client = Client::findOrFail($id);
        $user = User::with(['client'])
            ->find($client->user_id);
        $user_locations = UserLocation::with(['city', 'area'])->where('user_id', $client->user_id)->get();
        if ($user->type != 3) {
            abort(404);
        }
        $data['client'] = array();
        $locations = array();
        foreach ($user_locations as $index => $l) {
            $locations[$index]['id'] = $l->id;
            $locations[$index]['location'] = $l->getTranslateName($lang);
            $locations[$index]['city'] = $l->city ? $l->city->getTranslateName($lang) : '';
            $locations[$index]['area'] = $l->area ? $l->area->getTranslateName($lang) : '';
        }
        if ($user->client) {
            $data['client']['id'] = $client->id;
            $data['client']['name'] = $user->name;
            $data['client']['email'] = $user->email;
            $data['client']['phone'] = $user->phone;
            $data['client']['image'] = $user->image_path;
            $data['client']['type'] = $client->type_name;
            $data['client']['locations'] = $locations;

        }
        $apis->createApiResponse(false, 200, "  ", $data);
        return;
    }


    public function store(Request $request)
    {
        $apis = new ApiHelper();
        $lang = $request->header('lang');
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

            }
            $user = User::create($data);
            if ($user) {
                Client::create([
                    'user_id' => $user->id,
                    'type_id' => $request->client_type,
                ]);
            }
            $role = Role::find(2);
            if ($role)
                $user->syncRoles([$role->name]);
            $apis->createApiResponse(false, 200, __('api.' . $lang . '.updated_done'), "");
        }

    }


    public function update($id, Request $request)
    {
        $apis = new ApiHelper();
        $lang = $request->header('lang');
        $client = Client::findOrFail($id);
        $user = User::find($client->user_id);
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
                        'type_id' => $request->client_type
                    ]);
                }
            }
            $role = Role::find(2);
            if ($role)
                $user->syncRoles([$role->name]);
            $apis->createApiResponse(false, 200, __('api.' . $lang . '.updated_done'), "");
            return;
        }
    }

    public function types(Request $request)
    {
        $apis = new ApiHelper();
        $lang = $request->header('lang');
        $user = $request->user();

        $types = ClientType::all();
        $data['types'] = array();
        foreach ($types as $index => $type) {
            $data['types'][$index]['id'] = $type->id;
            $data['types'][$index]['name'] = $type->getTranslateName($lang);
        }
        $apis->createApiResponse(false, 200, "  ", $data);
        return;
    }

}
