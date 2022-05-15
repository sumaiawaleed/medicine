<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Category;
use App\Models\City;
use App\Models\Client;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class AutocompleteController extends Controller
{
    public function parents(Request $request)
    {
        $categories = Category::when($request->q, function ($q) use ($request) {
            return $q->where('name', 'LIKE', '%' . $request->q . '%');
        })->where('parent_id', 0)->select("id", "name")
            ->get()->take(20);
        $data = array();
        foreach ($categories as $index => $category) {
            $data[$index]['id'] = $category->id;
            $data[$index]['name'] = $category->getTranslateName(app()->getLocale());
        }
        return response()->json($data);
    }

    public function categories(Request $request)
    {

        if ($request->parent_id) {
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
        foreach ($cities as $index => $city) {
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
            return $q->where('city_id', '=', $request->city);
        })->get()->take(20);
        $data = array();
        foreach ($areas as $index => $area) {
            $data[$index]['id'] = $area->id;
            $data[$index]['name'] = $area->getTranslateName(app()->getLocale());
        }
        return response()->json($data);
    }

    public function clients(Request $request)
    {
        $clients = User::with('client')
            ->where('type', '3')->when($request->q, function ($q) use ($request) {
                return $q->where('name', 'LIKE', '%' . $request->q . '%');
            })->get()->take(20);
        $data = array();
        foreach ($clients as $index => $client) {
            if ($client->client) {
                $data[$index]['id'] = $client->client->id;
                $data[$index]['name'] = $client->name;
            }
        }
        return response()->json($data);
    }

    public function employees(Request $request)
    {
        $employees = User::where('type', '2')->when($request->q, function ($q) use ($request) {
            return $q->where('name', 'LIKE', '%' . $request->q . '%');
        })->get()->take(20);
        $data = array();
        foreach ($employees as $index => $employee) {
            $data[$index]['id'] = $employee->id;
            $data[$index]['name'] = $employee->name;
        }
        return response()->json($data);
    }

    public function orders(Request $request)
    {
        $orders = Order::when($request->q, function ($q) use ($request) {
            return $q->where('id', 'LIKE', '%' . $request->q . '%');
        })->get()->take(20);
        $data = array();
        foreach ($orders as $index => $order) {
            $data[$index]['id'] = $order->id.__('site.total').'  : '.($order->total + 0);
        }
        return response()->json($data);
    }

    public function get_data(Request $request){
        try{
            $id_array = explode(__('site.total'), $request->id);
            $order_id = $id_array[0];
            $order = Order::with('employee')->findOrFail($order_id);
            return response()->json(array(
                'success' => true,
                'clients' => '<option selected value="'.$order->client_id.'">'.$order->getClient()->name.'</option>',
                'employees' => '<option selected value="'.$order->sales_person_id.'">'.$order->employee->name.'</option>'

            ), 200);
        }catch (\Exception $ex){
            return response()->json(array(
                'success' => true),200);
        }
    }
}
