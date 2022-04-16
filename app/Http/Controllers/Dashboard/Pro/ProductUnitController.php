<?php

namespace App\Http\Controllers\Dashboard\Pro;

use App\DataTables\Main\CategoryDataTable;
use App\DataTables\Pro\ProductUnitDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductUnitController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:product_units-read'])->only('index', 'show');
        $this->middleware(['permission:product_units-create'])->only('create', 'store');
        $this->middleware(['permission:product_units-update'])->only('edit', 'update');
        $this->middleware(['permission:product_units-delete'])->only('destroy');
    }//end of constructor

    private function validate_page($request , $data = "")
    {
        $rules = [
            'unit_id' => 'required',
            'price' => 'required',
            'quantity' => 'required',
        ];

        if(!$data){
            $rules +=['product_id' => 'required'];
        }
        $validator = Validator::make($request->all(), $rules);
        return $validator;
    }

    public function index(Request $request){
        $data['product'] = Product::findOrFail($request->id);
        $dataTable = new ProductUnitDataTable($request->id);
        $data['title'] = $data['product']->getTranslateName(app()->getLocale());
        return $dataTable->render('dashboard.product.products.units.index',compact('data'));
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
            ProductUnit::create([
                'unit_id' => $request->unit_id,
                'product_id' => $request->product_id,
                'price' => $request->price,
                'quantity' => $request->quantity,
            ]);
            return response()->json(array('success' => true), 200);
        }
    }

    public function edit($id)
    {
        $form_data = ProductUnit::findOrFail($id);
        $returnHTML = view('dashboard.product.products.units.partials._edit',compact('form_data'))->render();
        return $returnHTML;
    }

    public function update(Request $request,$id)
    {
        $product_unit = ProductUnit::findOrFail($request->id);
        $validator = $this->validate_page($request,$product_unit);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {
            $product_unit->update([
                'unit_id' => $request->unit_id,
                'price' => $request->price,
                'quantity' => $request->quantity,
            ]);
            return response()->json(array('success' => true), 200);
        }
    }

    public function remove($id)
    {
        $product_unit = ProductUnit::findOrFail($id);
        $product_unit->delete();
        return response()->json(array('success' => true));
    }

}
