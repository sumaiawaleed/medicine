<?php

namespace App\Http\Controllers\Dashboard\Pro;

use App\DataTables\Pro\ProductDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductConversionUnit;
use App\Models\ProductUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ProductController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:products-read'])->only('index', 'show');
        $this->middleware(['permission:products-create'])->only('create', 'store');
        $this->middleware(['permission:products-update'])->only('edit', 'update');
        $this->middleware(['permission:products-delete'])->only('destroy');
    }//end of constructor

    public function index(ProductDataTable $dataTable,Request $request){
        $data['title'] = __('site.products');
        return $dataTable->render('dashboard.product.products.index',compact('data'));
    }

    private function validate_page($request , $data = "")
    {
        $rules = [
            'category_id' => 'required',
            'expire_date' => 'required',
            'notes' => 'required',
            'scientific_name' => 'required',
        ];

        foreach(LaravelLocalization::getSupportedLocales() as $locale => $properties) {
            $rules += [$locale . '_product_name' => ['required']];
        }

        if(!$data){
            $rules +=[
                'image' => 'required',
            ];
        }

        $validator = Validator::make($request->all(), $rules);

        return $validator;

    }

    public function show($id){
        $form_data = Product::findOrFail($id);
        $data['title'] = $form_data->getTranslateName(app()->getLocale());
        $data['product_units'] = ProductUnit::where('product_id',$id)->get();
        $data['product_conversion_units'] = ProductConversionUnit::where('product_id',$id)->get();
        return view('dashboard.product.products.show',compact('data','form_data'));
    }

    public function create(Request $request){
        $data['title'] = __('site.create').' '.__('site.one_products');
        return view('dashboard.product.products.create',compact('data'));
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

                $n = $locale."_product_name";
                $name_array[$locale] = $request->$n;
            }
            $data = [
                'name' => json_encode($name_array,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
                'category_id' => $request->category_id,
                'expire_date' => $request->expire_date,
                'is_available' => ($request->is_available) ? 1 : 0,
                'notes' => $request->notes,
                'scientific_name' => $request->scientific_name,
            ];
            if ($request->image) {
                Image::make($request->image)
                    ->save(public_path('uploads/products/' . $request->image->hashName()));
                $data['image'] = $request->image->hashName();
            }
            Product::create($data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function edit($id)
    {
        $form_data = Product::findOrFail($id);
        $data['title'] = __('site.edit').' '.__('site.one_products');
        $data['category'] = Category::find($form_data->category_id);
        $data['parent'] = Category::find($data['category']->parent_id);
        return view('dashboard.product.products.edit',compact('form_data','data'));
    }

    public function update(Request $request,$id)
    {
        $product = Product::findOrFail($request->id);
        $validator = $this->validate_page($request,$product);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {
            $name_array = array();
            foreach(LaravelLocalization::getSupportedLocales() as $locale => $properties) {

                $n = $locale."_product_name";
                $name_array[$locale] = $request->$n;
            }
            $data = [
                'name' => json_encode($name_array,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
                'category_id' => $request->category_id,
                'expire_date' => $request->expire_date,
                'is_available' => ($request->is_available) ? 1 : 0,
                'notes' => $request->notes,
                'scientific_name' => $request->scientific_name,
            ];
            if ($request->image) {
                $path= 'public/uploads/products/'.$product->image;
                if (file_exists($path)) {
                    unlink($path);
                }
                Image::make($request->image)
                    ->save(public_path('uploads/products/' . $request->image->hashName()));
                $data['image'] = $request->image->hashName();
            }
            $product->update($data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function remove($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(array('success' => true));
    }


}
