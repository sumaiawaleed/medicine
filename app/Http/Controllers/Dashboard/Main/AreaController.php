<?php

namespace App\Http\Controllers\Dashboard\Main;

use App\DataTables\Main\AreaDataTable;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AreaController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:areas-read'])->only('index', 'show');
        $this->middleware(['permission:areas-create'])->only('create', 'store');
        $this->middleware(['permission:areas-update'])->only('edit', 'update');
        $this->middleware(['permission:areas-delete'])->only('destroy');
    }//end of constructor

    public function index(AreaDataTable $dataTable,Request $request){
        $data['title'] = __('site.areas');
        return $dataTable->render('dashboard.main.areas.index',compact('data'));
    }

    private function validate_page($request , $data = "")
    {
        $rules = [
            'city_id' => 'required'
        ];
        foreach(LaravelLocalization::getSupportedLocales() as $locale => $properties) {
            $rules += [$locale . '_area_name' => ['required']];
        }
        $validator = Validator::make($request->all(), $rules);

        return $validator;

    }

    public function show($id){
        $form_data = Area::findOrFail($id);
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
            foreach(LaravelLocalization::getSupportedLocales() as $locale => $properties) {

                $n = $locale."_area_name";
                $name_array[$locale] = $request->$n;
            }
            $request_data = [
                'name' => json_encode($name_array,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
                'city_id' => ($request->city_id) ? $request->city_id : 0,
            ];
            Area::create($request_data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function edit($id)
    {
        $form_data = Area::findOrFail($id);
        $data['city']  = City::find($form_data->city_id);
        $returnHTML = view('dashboard.main.areas.partials._edit',compact('form_data','data'))->render();
        return $returnHTML;
    }

    public function update(Request $request,$id)
    {
        $area = Area::findOrFail($request->id);
        $validator = $this->validate_page($request,$area);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {
            $name_array = array();
            foreach(LaravelLocalization::getSupportedLocales() as $locale => $properties) {

                $n = $locale."_area_name";
                $name_array[$locale] = $request->$n;
            }
            $request_data = [
                'name' => json_encode($name_array,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
                'city_id' => ($request->city_id) ? $request->city_id : 0,
            ];
            $area->update($request_data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function remove($id)
    {
        $area = Area::findOrFail($id);
        $area->delete();
        return response()->json(array('success' => true));
    }

}
