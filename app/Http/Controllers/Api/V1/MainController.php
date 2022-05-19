<?php

namespace App\Http\Controllers\Api\V1;

use App\Functions\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Category;
use App\Models\City;
use App\Models\Location;
use App\Models\Product;
use App\Models\ProductUnit;
use App\Models\Subscribe;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function cities(Request $request)
    {
        $apis = new ApiHelper();
        $lang = $request->header('lang');
        $data['cities'] = City::orderByDesc('id')->paginate(20);
        foreach ($data['cities'] as $index => $city) {
            $city->name = $city->getTranslateName($lang);
        }
        $apis->createApiResponse(false, 200, "  ", $data);
        return;
    }

    public function subscribes(Request $request)
    {
        $apis = new ApiHelper();
        $lang = $request->header('lang');
        $data['subscribes'] = Subscribe::orderByDesc('id')->paginate(20);
        foreach ($data['subscribes'] as $index => $sub) {
            $sub->name = $sub->getTranslateName($lang);
            $sub->description = $sub->getTranslateDesc($lang);
        }
        $apis->createApiResponse(false, 200, "  ", $data);
        return;
    }

    public function areas(Request $request)
    {
        $apis = new ApiHelper();
        $lang = $request->header('lang');
        $data['areas'] = Area::when($request->city_id, function ($q) use ($request) {
            return $q->where('city_id', '=', $request->city_id);
        })->orderByDesc('id')->paginate(20);
        foreach ($data['areas'] as $index => $area) {
            $area->name = $area->getTranslateName($lang);
        }
        $apis->createApiResponse(false, 200, "  ", $data);
        return;
    }

    public function locations(Request $request)
    {
        $apis = new ApiHelper();
        $lang = $request->header('lang');
        $data['locations'] = Location::when($request->city_id, function ($q) use ($request) {
            return $q->where('city_id', '=', $request->city_id);
        })->when($request->area_id, function ($q) use ($request) {
            return $q->where('area_id', '=', $request->area_id);
        })->orderByDesc('id')->paginate(20);
        foreach ($data['locations'] as $index => $location) {
            $location->address = $location->getTranslateAddress($lang);
        }
        $apis->createApiResponse(false, 200, "  ", $data);
        return;
    }

    public function categories(Request $request)
    {
        $apis = new ApiHelper();
        $lang = $request->header('lang');
        $data['categories'] = array();
        if ($request->parent_id) {
            $data['categories'] = Category::when($request->parent_id, function ($q) use ($request) {
                return $q->where('parent_id', '=', $request->parent_id);
            })->orderByDesc('id')->paginate(20);
        } else {
            $data['categories'] = Category::where('parent_id', 0)
                ->orderByDesc('id')->paginate(20);
        }
        foreach ($data['categories'] as $index => $category) {
            $category->name = $category->getTranslateName($lang);
        }
        $apis->createApiResponse(false, 200, "  ", $data);
        return;
    }

    public function products(Request $request)
    {
        $apis = new ApiHelper();
        $lang = $request->header('lang');
        $data['products'] = array();
        $data['products'] = Product::when($request->category_id, function ($q) use ($request) {
            return $q->where('category_id', '=', $request->category_id);
        })->orderByDesc('id')->paginate(20);

        foreach ($data['products'] as $index => $product) {
            $product->name = $product->getTranslateName($lang);
            $product->category_name = $product->get_category_name($lang);
        }
        $apis->createApiResponse(false, 200, "  ", $data);
        return;
    }

    public function all_products(Request $request)
    {
        $apis = new ApiHelper();
        $lang = $request->header('lang');
        $data['products'] = array();
        $data['products'] = Product::with('units')->when($request->category_id, function ($q) use ($request) {
            return $q->where('category_id', '=', $request->category_id);
        })->orderByDesc('id')->get();

        foreach ($data['products'] as $index => $product) {
            $product->name = $product->getTranslateName($lang);
            $product->category_name = $product->get_category_name($lang);
            $product->unitis = $product->get_category_name($lang);
        }
        $apis->createApiResponse(false, 200, "  ", $data);
        return;
    }
}
