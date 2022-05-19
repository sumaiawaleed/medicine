<?php

namespace App\Http\Controllers\Dashboard\Main;

use App\DataTables\Main\SubscribeDataTable;
use App\Http\Controllers\Controller;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class SubscribeController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:subscribes-read'])->only('index', 'show');
        $this->middleware(['permission:subscribes-create'])->only('create', 'store');
        $this->middleware(['permission:subscribes-update'])->only('edit', 'update');
        $this->middleware(['permission:subscribes-delete'])->only('destroy');
    }//end of constructor

    public function index(SubscribeDataTable $dataTable,Request $request){
        $data['title'] = __('site.subscribes');
        return $dataTable->render('dashboard.main.subscribes.index',compact('data'));
    }

    private function validate_page($request , $data = "")
    {
        $rules = [
            'price' => 'required',
            'period' => 'required',
        ];
        foreach(LaravelLocalization::getSupportedLocales() as $locale => $properties) {
            $rules += [$locale . '_name' => ['required']];
            $rules += [$locale . '_description' => ['required']];
        }

        $validator = Validator::make($request->all(), $rules);

        return $validator;

    }

    public function show($id){
        $form_data = Subscribe::findOrFail($id);
        return json_encode($form_data);
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
            $name_array = array();
            $desc_array = array();
            foreach(LaravelLocalization::getSupportedLocales() as $locale => $properties) {

                $n = $locale."_name";
                $d = $locale."_description";
                $name_array[$locale] = $request->$n;
                $desc_array[$locale] = $request->$d;
            }
            $request_data = [
                'price' => $request->price,
                'period' => $request->period,
                'name' => json_encode($name_array,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
                'description' => json_encode($desc_array,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
            ];
            Subscribe::create($request_data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function edit($id)
    {
        $form_data = Subscribe::findOrFail($id);
        $returnHTML = view('dashboard.main.subscribes.partials._edit',compact('form_data'))->render();
        return $returnHTML;
    }

    public function update(Request $request,$id)
    {
        $subscribe = Subscribe::findOrFail($request->id);
        $validator = $this->validate_page($request,$subscribe);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {$name_array = array();
            $desc_array = array();
            foreach(LaravelLocalization::getSupportedLocales() as $locale => $properties) {

                $n = $locale."_name";
                $d = $locale."_description";
                $name_array[$locale] = $request->$n;
                $desc_array[$locale] = $request->$d;
            }
            $request_data = [
                'price' => $request->price,
                'period' => $request->period,
                'name' => json_encode($name_array,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
                'description' => json_encode($desc_array,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
            ];
            $subscribe->update($request_data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function remove($id)
    {
        $subscribe = Subscribe::findOrFail($id);
        $subscribe->delete();
        return response()->json(array('success' => true));
    }

}
