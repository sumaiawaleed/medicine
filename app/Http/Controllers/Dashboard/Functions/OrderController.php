<?php

namespace App\Http\Controllers\Dashboard\Functions;

use App\DataTables\Functions\OrderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:orders-read'])->only('index', 'show');
        $this->middleware(['permission:orders-create'])->only('create', 'store');
        $this->middleware(['permission:orders-update'])->only('edit', 'update');
        $this->middleware(['permission:orders-delete'])->only('destroy');
    }//end of constructor

    public function index(Request $request){
        $dataTable = new OrderDataTable(0,0);
        $data['title'] = __('site.orders');
        return $dataTable->render('dashboard.functions.orders.index',compact('data'));
    }

    private function validate_page($request , $data = "")
    {
        $rules =
            [
                'total' => 'required',
                'status' => 'required',
            ];
        $validator = Validator::make($request->all(), $rules);
        return $validator;
    }

    public function show($id){
        $data['order'] = Order::with('employee')->findOrFail($id);
        $data['title'] = __('site.order_no').' '.$id;
        $data['items']  = OrderItem::with('product')->where('order_id',$id)->get();
        $data['invoices']  = Invoice::with('employee')->where('order_id',$id)->get();
        return view('dashboard.functions.orders.show',compact('data'));
    }

    public function edit($id)
    {
        $form_data = Order::findOrFail($id);
        $returnHTML = view('dashboard.functions.orders.partials._edit',compact('form_data'))->render();
        return $returnHTML;
    }

    public function update(Request $request,$id)
    {
        $order = Order::findOrFail($request->id);
        $validator = $this->validate_page($request,$order);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {
            $request_data =[
                'total' => $request->total,
                'status' => $request->status
            ];
            $order->update($request_data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function remove($id)
    {
        $order = Order::findOrFail($id);
        OrderItem::where('order_id',$id)->delete();
        $order->delete();
        return response()->json(array('success' => true));
    }
}
