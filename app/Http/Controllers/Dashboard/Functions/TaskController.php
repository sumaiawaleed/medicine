<?php

namespace App\Http\Controllers\Dashboard\Functions;

use App\DataTables\Functions\TaskDataTable;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\City;
use App\Models\Client;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:tasks-read'])->only('index', 'show');
        $this->middleware(['permission:tasks-create'])->only('create', 'store');
        $this->middleware(['permission:tasks-update'])->only('edit', 'update');
        $this->middleware(['permission:tasks-delete'])->only('destroy');
    }//end of constructor

    public function index(Request $request){
        $dataTable = new TaskDataTable(0,0);
        $data['title'] = __('site.tasks');
        return $dataTable->render('dashboard.functions.tasks.index',compact('data'));
    }

    private function validate_page($request , $data = "")
    {
        $rules =
            [
                'name' => 'required',
                'client_id' => 'required',
                'sales_person_id' => 'required',
                'location' => 'required',
                'city_id' => 'required',
                'area_id' => 'required',
                'from_date' => 'required',
                'to_date' => 'required',
                'notes' => 'required',
                'status' => 'required',
            ];
        $validator = Validator::make($request->all(), $rules);
        return $validator;
    }

    public function show($id){
        $form_data = Task::findOrFail($id);
        return json_encode($form_data);
    }

    public function create(Request $request){
        $data['title'] = __('site.create').' '.__('site.one_tasks');
       if(isset($request->client_id)){
           $data['emp'] = User::find($request->emp_id);
       }
       if(isset($request->client_id)){
           $data['client'] = Client::with('user')->where('user_id',$request->client_id)->first();
       }
        return view('dashboard.functions.tasks.create',compact('data'));
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
            $request_data =[
                'name' => $request->name,
                'client_id' => $request->client_id,
                'sales_person_id' => $request->sales_person_id,
                'location' => $request->location,
                'city_id' => $request->city_id,
                'area_id' => $request->area_id,
                'lat' => $request->lat,
                'log' => $request->log,
                'from_date' => $request->from_date,
                'to_date' => $request->to_date,
                'notes' => $request->notes,
                'status' => $request->status
            ];
            Task::create($request_data);
            return response()->json(array('success' => true), 200);
        }
    }


    public function edit($id)
    {
        $form_data = Task::findOrFail($id);
        $data['title'] = __('site.edit').' '.__('site.one_tasks');
        $data['emp'] = User::find($form_data->sales_person_id);
        $data['client'] = Client::with('user')->find($form_data->client_id);
        $data['area'] = Area::find($form_data->area_id);
        $data['city'] = City::find($form_data->city_id);
        return view('dashboard.functions.tasks.edit',compact('data','form_data'));
    }

    public function update(Request $request,$id)
    {
        $task = Task::findOrFail($request->id);
        $validator = $this->validate_page($request,$task);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {
            $request_data =[
                'name' => $request->name,
                'client_id' => $request->client_id,
                'sales_person_id' => $request->sales_person_id,
                'location' => $request->location,
                'city_id' => $request->city_id,
                'area_id' => $request->area_id,
                'lat' => $request->lat,
                'log' => $request->log,
                'from_date' => $request->from_date,
                'to_date' => $request->to_date,
                'notes' => $request->notes,
                'status' => $request->status
            ];
            $task->update($request_data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function remove($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return response()->json(array('success' => true));
    }
}
