<?php

namespace App\Http\Controllers\Dashboard\People;

use App\DataTables\Functions\InvoiceDataTable;
use App\DataTables\Functions\OrderDataTable;
use App\DataTables\Functions\TaskDataTable;
use App\DataTables\People\EmployeeDataTable;
use App\DataTables\People\UserLocationDataTable;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class EmployeeController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:employees-read'])->only('index', 'show');
        $this->middleware(['permission:employees-create'])->only('create', 'store');
        $this->middleware(['permission:employees-update'])->only('edit', 'update');
        $this->middleware(['permission:employees-delete'])->only('destroy');
    }//end of constructor

    public function index(EmployeeDataTable $dataTable,Request $request){
        $data['title'] = __('site.employees');
        return $dataTable->render('dashboard.people.employees.index',compact('data'));
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

    public function show($id){
        $form_data = User::findOrFail($id);
        if($form_data->type != 2){
            abort(404);
        }
        $data['page'] = 'edit';
        $data['title'] = $form_data->name.' '.__('site.profile');
        $data['user'] = $form_data;
        $data['orders'] = Order::where('sales_person_id',$id)->count();
        $data['tasks'] = Task::where('sales_person_id',$id)->count();
        $data['invoices'] = Invoice::where('sales_person_id',$id)->count();
        return view('dashboard.people.employees.show',compact('data','form_data'));
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
                'type' => 2,
            ];
            if ($request->image) {
                Image::make($request->image)
                    ->save(public_path('uploads/users/' . $request->image->hashName()));
                $data['image'] = $request->image->hashName();
            }
            $user = User::create($data);
            $role = Role::find(3);
            if ($role)
            $user->syncRoles([$role->name]);

            return response()->json(array('success' => true), 200);
        }
    }

    public function edit($id)
    {
        $form_data = User::findOrFail($id);
        $returnHTML = view('dashboard.people.employees.partials._edit',compact('form_data'))->render();
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
            return response()->json(array('success' => true), 200);
        }
    }

    public function remove($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(array('success' => true));
    }

    public function invoices($id){
        $data['page'] = 'invoices';
        $form_data = User::findOrFail($id);
        if($form_data->type != 2){
            abort(404);
        }
        $data['emp'] = $form_data;
        $data['title'] = $form_data->name.' '.__('site.invoices');
        $data['user'] = $form_data;
        $data['orders'] = Order::where('sales_person_id',$id)->count();
        $data['tasks'] = Task::where('sales_person_id',$id)->count();
        $data['invoices'] = Invoice::where('sales_person_id',$id)->count();
        $dataTable = new InvoiceDataTable(0,$id,0);
        return $dataTable->render('dashboard.people.employees.functions._invoices',compact('data'));
    }

    public function orders($id){
        $data['page'] = 'orders';
        $form_data = User::findOrFail($id);
        if($form_data->type != 2){
            abort(404);
        }
        $data['emp'] = $form_data;
        $data['title'] = $form_data->name.' '.__('site.orders');
        $data['user'] = $form_data;
        $data['orders'] = Order::where('sales_person_id',$id)->count();
        $data['tasks'] = Task::where('sales_person_id',$id)->count();
        $data['invoices'] = Invoice::where('sales_person_id',$id)->count();
        $dataTable = new OrderDataTable(0,$id);
        return $dataTable->render('dashboard.people.employees.functions._orders',compact('data'));
    }

    public function tasks($id){
        $data['page'] = 'tasks';
        $form_data = User::findOrFail($id);
        if($form_data->type != 2){
            abort(404);
        }
        $data['emp'] = $form_data;
        $data['title'] = $form_data->name.' '.__('site.tasks');
        $data['user'] = $form_data;
        $data['orders'] = Order::where('sales_person_id',$id)->count();
        $data['tasks'] = Task::where('sales_person_id',$id)->count();
        $data['invoices'] = Invoice::where('sales_person_id',$id)->count();
        $dataTable = new TaskDataTable(0,$id);
        return $dataTable->render('dashboard.people.employees.functions._tasks',compact('data'));
    }

    public function locations($id){
        $data['page'] = 'locations';
        $form_data = User::findOrFail($id);
        if($form_data->type != 2){
            abort(404);
        }
        $data['emp'] = $form_data;
        $data['title'] = $form_data->name.' '.__('site.locations');
        $data['user'] = $form_data;
        $data['orders'] = Order::where('sales_person_id',$id)->count();
        $data['tasks'] = Task::where('sales_person_id',$id)->count();
        $data['invoices'] = Invoice::where('sales_person_id',$id)->count();
        $dataTable = new UserLocationDataTable($id);
        return $dataTable->render('dashboard.people.employees.functions._locations',compact('data'));
    }
}
