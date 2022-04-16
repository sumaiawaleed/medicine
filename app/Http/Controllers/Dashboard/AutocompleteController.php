<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Category;
use App\Models\City;
use Illuminate\Http\Request;

class AutocompleteController extends Controller
{
    public function parents(Request $request)
    {
        $categories = Category::when($request->q, function ($q) use ($request) {
            return $q->where('name', 'LIKE', '%' . $request->q . '%');
        })->where('parent_id',0)->select("id", "name")
            ->get()->take(20);
        $data = array();
        foreach ($categories as $index=>$category){
            $data[$index]['id'] = $category->id;
            $data[$index]['name'] = $category->getTranslateName(app()->getLocale());
        }
        return response()->json($data);
    }

    public function categories(Request $request)
    {

        if($request->parent_id) {
            $categories = Category::when($request->q, function ($q) use ($request) {
                return $q->where('name', 'LIKE', '%' . $request->q . '%');
            })->where('parent_id', $request->parent_id)->select("id", "name")
                ->get()->take(20);
            $data = array();
            foreach ($categories as $index => $category) {
                $data[$index]['id'] = $category->id;
                $data[$index]['name'] = $category->getTranslateName(app()->getLocale());
            }
            return response()->json($data);
        }
    }

    public function cities(Request $request)
    {
        $cities = City::when($request->q, function ($q) use ($request) {
            return $q->where('name', 'LIKE', '%' . $request->q . '%');
        })->get()->take(20);
        $data = array();
        foreach ($cities as $index=>$city){
            $data[$index]['id'] = $city->id;
            $data[$index]['name'] = $city->getTranslateName(app()->getLocale());
        }
        return response()->json($data);
    }

    public function areas(Request $request)
    {
        $areas = Area::when($request->q, function ($q) use ($request) {
            return $q->where('name', 'LIKE', '%' . $request->q . '%');
        })->when($request->city, function ($q) use ($request) {
            return $q->where('city_id','=',$request->city);
        })->get()->take(20);
        $data = array();
        foreach ($areas as $index=>$area){
            $data[$index]['id'] = $area->id;
            $data[$index]['name'] = $area->getTranslateName(app()->getLocale());
        }
        return response()->json($data);
    }
}
