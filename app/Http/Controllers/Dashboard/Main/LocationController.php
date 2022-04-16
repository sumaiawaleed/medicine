<?php

namespace App\Http\Controllers\Dashboard\Main;

use App\DataTables\Main\LocationDataTable;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Models\Location;

class LocationController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:locations-read'])->only('index', 'show');
        $this->middleware(['permission:locations-create'])->only('create', 'store');
        $this->middleware(['permission:locations-update'])->only('edit', 'update');
        $this->middleware(['permission:locations-delete'])->only('destroy');
    }//end of constructor

    public function index(LocationDataTable $dataTable,Request $request){
        $data['title'] = __('site.locations');
        return $dataTable->render('dashboard.main.locations.index',compact('data'));
    }

    private function validate_page($request , $data = "")
    {
        $rules = [
            'city_id' => 'required',
            'area_id' => 'required',
            'lat' => 'required',
            'log' => 'required',
        ];
        foreach(LaravelLocalization::getSupportedLocales() as $locale => $properties) {
            $rules += [$locale . '_address' => ['required']];
        }
        $validator = Validator::make($request->all(), $rules);

        return $validator;

    }

    public function show($id){
        $form_data = Location::findOrFail($id);
        return json_encode($form_data);
    }

    public function create(Request $request){
        $data['title'] = __('site.create').' '.__('site.one_locations');
        return view('dashboard.main.locations.create',compact('data'));
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

                $n = $locale."_address";
                $name_array[$locale] = $request->$n;
            }
            $request_data = [
                'address' => json_encode($name_array,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
                'city_id' => ($request->city_id) ? $request->city_id : 0,
                'area_id' => ($request->area_id) ? $request->area_id : 0,
                'lat' => $request->lat,
                'log' => $request->log,
            ];
            Location::create($request_data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function edit($id)
    {
        $data['title'] = __('site.edit').' '.__('site.one_locations');
        $form_data = Location::findOrFail($id);
        $data['city']  = City::find($form_data->city_id);
        $data['area']  = Area::find($form_data->area_id);
        return view('dashboard.main.locations.edit',compact('form_data','data'));
    }

    public function update(Request $request,$id)
    {
        $location = Location::findOrFail($request->id);
        $validator = $this->validate_page($request,$location);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {
            $name_array = array();
            foreach(LaravelLocalization::getSupportedLocales() as $locale => $properties) {

                $n = $locale."_address";
                $name_array[$locale] = $request->$n;
            }
            $request_data = [
                'address' => json_encode($name_array,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
                'city_id' => ($request->city_id) ? $request->city_id : 0,
                'area_id' => ($request->area_id) ? $request->area_id : 0,
                'lat' => $request->lat,
                'log' => $request->log,
            ];
            $location->update($request_data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function remove($id)
    {
        $location = Location::findOrFail($id);
        $location->delete();
        return response()->json(array('success' => true));
    }

}
