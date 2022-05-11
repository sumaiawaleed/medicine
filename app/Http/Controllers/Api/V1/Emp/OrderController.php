<?php

namespace App\Http\Controllers\Api\V1\Emp;

use App\Functions\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $apis = new ApiHelper();
        $user = $request->user('api');
        $lang = $request->header('lang');
        if ($user->type == 2) {
            $data['orders'] = Order::where('sales_person_id', $user->id)
                ->orderByDesc('id')
                ->paginate(20);
            foreach ($data['orders'] as $index => $order) {
                $order->status_name = __('api.' . $lang . '.orders.' . $order->status);
            }
            $apis->createApiResponse(false, 200, "  ", $data);
            return;
        } else {
            abort(404);
        }
    }

    public function store(Request $request)
    {
        $apis = new ApiHelper();
        $user = $request->user('api');
        $lang = $request->header('lang');
        if ($user->type == 2) {
            try {
                $order_data = [
                    'client_id' => $request->client_id,
                    'sales_person_id' => $user->id,
                    'total' => ($request->total) ? $request->total : 0,
                    'status' => $request->status
                ];
                $new_order = Order::create($order_data);


                $details = json_decode($request->details, true);
                foreach ($details as $index => $d) {
                    OrderItem::create([
                        'product_id' => $d['product_id'],
                        'order_id' => $new_order->id,
                        'quantity' => $d['quantity']
                    ]);
                }
                $apis->createApiResponse(false, 200, __('api.' . $lang . '.updated_done'), "");
                return;
            } catch (\Exception $ex) {
                abort(404);
            }
        }
        else {
            abort(404);
        }
    }

    public function update($id, Request $request)
    {
        $apis = new ApiHelper();
        $order = Order::findOrFail($id);
        $user = $request->user('api');
        $lang = $request->header('lang');
        if ($user->type == 2 and $order->sales_person_id == $user->id) {
            try {
                $order_data = [
                    'client_id' => $request->client_id,
                    'total' => ($request->total) ? $request->total : 0,
                    'status' => $request->status
                ];
                $order->update($order_data);
                $apis->createApiResponse(false, 200, __('api.' . $lang . '.updated_done'), "");
                return;
            } catch (\Exception $ex) {
                $apis->createApiResponse(true, 200, "error", "");
            }
        }
        else {
            abort(404);
        }
    }

    public function show($id,Request $request){
        $apis = new ApiHelper();
        $order = Order::with('client')->findOrFail($id);
        $user = $request->user('api');
        $lang = $request->header('lang');
        if ($user->type == 2 and $order->sales_person_id == $user->id) {
            $user = ($order->client) ? User::find($order->client->user_id) : '';
            $order->status_name = __('api.'.$lang.'.orders.'.$order->status);
            $order->client_name = $user ? $user->name : '';
            $data['order'] = $order;
            $order_items  = OrderItem::with('product')->where('order_id',$id)->get();
            $items = array();
            foreach ($order_items as $index=>$item){
                $items[$index]['id'] = $item->id;
                $items[$index]['quantity'] = $item->quantity;
                $items[$index]['product_id'] = $item->product_id;
                $items[$index]['product_name'] = $item->product ? $item->product->getTranslateName($lang) : '';
            }
            $data['items'] = $items;

            $invoices = Invoice::where('order_id',$id)->where('client_id', $user->id)->orderByDesc('id')
                ->get();
            $data['invoices'] = array();
            foreach ($invoices as $index => $invoice) {
                $data['invoices'][$index]['id'] = $invoice->id;
                $data['invoices'][$index]['order_id'] = $invoice->order_id;
                $data['invoices'][$index]['total'] = $invoice->total;
                $data['invoices'][$index]['tax'] = $invoice->tax;
                $data['invoices'][$index]['notes'] = $invoice->notes;
                $data['invoices'][$index]['type'] = $invoice->type;
                $data['invoices'][$index]['type_name'] = __('api.' . $lang . '.types.' . $invoice->type);
                $data['invoices'][$index]['created_at'] = $invoice->created_at;
            }

            $apis->createApiResponse(false, 200, "", $data);
            return;
        }else{
            abort(404);
        }
    }

    public function add_item(Request $request){
        $apis = new ApiHelper();
        $order = Order::with('client')->find($request->order_id);
        $user = $request->user('api');
        $lang = $request->header('lang');
        if ($user->type == 2 and $order->sales_person_id == $user->id) {
            $item_data = [
                'product_id' => $request->product_id,
                'order_id' => $request->order_id,
                'quantity' => $request->quantity
            ];
            OrderItem::create($item_data);
            $apis->createApiResponse(false, 200, __('api.' . $lang . '.added_successfully'), "");
        }else{
            abort(404);
        }
    }

    public function edit_item(Request $request){
        $apis = new ApiHelper();
        $order = Order::with('client')->findOrFail($request->order_id);
        $item = OrderItem::findOrFail($request->item_id);
        $user = $request->user('api');
        $lang = $request->header('lang');
        if ($user->type == 2 and $order->sales_person_id == $user->id and $item->order_id = $request->order_id) {
            $item_data = [
                'product_id' => $request->product_id,
                'order_id' => $request->order_id,
                'quantity' => $request->quantity
            ];
            $item->update($item_data);
            $apis->createApiResponse(false, 200, __('api.' . $lang . '.updated_done'), "");
        }else{
            abort(404);
        }
    }

    public function delete_item(Request $request){
        $apis = new ApiHelper();
        $order = Order::with('client')->findOrFail($request->order_id);
        $item = OrderItem::findOrFail($request->item_id);
        $user = $request->user('api');
        $lang = $request->header('lang');
        if ($user->type == 2 and $order->sales_person_id == $user->id and $item->order_id = $request->order_id) {
            $item->delete();
            $apis->createApiResponse(false, 200, __('api.' . $lang . '.delete_done'), "");
        }else{
            abort(404);
        }
    }
}
