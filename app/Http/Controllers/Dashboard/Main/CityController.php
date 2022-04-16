<?php

namespace App\Http\Controllers\Dashboard\Main;

use App\DataTables\Main\CityDataTable;
use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CityController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:cities-read'])->only('index', 'show');
        $this->middleware(['permission:cities-create'])->only('create', 'store');
        $this->middleware(['permission:cities-update'])->only('edit', 'update');
        $this->middleware(['permission:cities-delete'])->only('destroy');
    }//end of constructor

    public function index(CityDataTable $dataTable,Request $request){
        $data['title'] = __('site.cities');
        return $dataTable->render('dashboard.main.cities.index',compact('data'));
    }

    private function validate_page($request , $data = "")
    {
        $rules = array();
        foreach(LaravelLocalization::getSupportedLocales() as $locale => $properties) {
            $rules += [$locale . '_city_name' => ['required']];
        }

        $validator = Validator::make($request->all(), $rules);

        return $validator;

    }

    public function show($id){
        $form_data = City::findOrFail($id);
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

                $n = $locale."_city_name";
                $name_array[$locale] = $request->$n;
            }
            $request_data = [
                'name' => json_encode($name_array,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
            ];
            City::create($request_data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function edit($id)
    {
        $form_data = City::findOrFail($id);
        $returnHTML = view('dashboard.main.cities.partials._edit',compact('form_data'))->render();
        return $returnHTML;
    }

    public function update(Request $request,$id)
    {
        $city = City::findOrFail($request->id);
        $validator = $this->validate_page($request,$city);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {
            $name_array = array();
            foreach(LaravelLocalization::getSupportedLocales() as $locale => $properties) {

                $n = $locale."_city_name";
                $name_array[$locale] = $request->$n;
            }
            $request_data = [
                'name' => json_encode($name_array,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
            ];
            $city->update($request_data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function remove($id)
    {
        $city = City::findOrFail($id);
        $city->delete();
        return response()->json(array('success' => true));
    }

}
