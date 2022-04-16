<?php

namespace App\Http\Controllers\Dashboard\Pro;

use App\DataTables\Pro\CategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CategoryController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:categories-read'])->only('index', 'show');
        $this->middleware(['permission:categories-create'])->only('create', 'store');
        $this->middleware(['permission:categories-update'])->only('edit', 'update');
        $this->middleware(['permission:categories-delete'])->only('destroy');
    }//end of constructor

    public function index(CategoryDataTable $dataTable,Request $request){
        $data['title'] = __('site.categories');
        return $dataTable->render('dashboard.main.categories.index',compact('data'));
    }

    private function validate_page($request , $data = "")
    {
        $rules = array();
        foreach(LaravelLocalization::getSupportedLocales() as $locale => $properties) {
            $rules += [$locale . '_category_name' => ['required']];
        }

        $validator = Validator::make($request->all(), $rules);

        return $validator;

    }

    public function show($id){
        $form_data = Category::findOrFail($id);
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

                $n = $locale."_category_name";
                $name_array[$locale] = $request->$n;
            }
            $request_data = [
                'name' => json_encode($name_array,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
                'parent_id' => ($request->parent_id) ? $request->parent_id : 0,
            ];
            Category::create($request_data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function edit($id)
    {
        $form_data = Category::findOrFail($id);
        $data['parent'] = Category::find($form_data->parent_id);
        $returnHTML = view('dashboard.main.categories.partials._edit',compact('form_data','data'))->render();
        return $returnHTML;
    }

    public function update(Request $request,$id)
    {
        $category = Category::findOrFail($request->id);
        $validator = $this->validate_page($request,$category);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {
            $name_array = array();
            foreach(LaravelLocalization::getSupportedLocales() as $locale => $properties) {

                $n = $locale."_category_name";
                $name_array[$locale] = $request->$n;
            }
            $request_data = [
                'name' => $name_array,
                'parent_id' => ($request->parent_id) ? $request->parent_id : 0,
            ];
            $category->update($request_data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function remove($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json(array('success' => true));
    }

}
