<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Functions\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request){
        $apis = new ApiHelper();
        $user = $request->user('api');
        $lang = $request->header('lang');
        $client = Client::where('user_id',$user->id)->first();
        if($client){
            $data['orders'] = Order::where('client_id',$client->id)
                ->orderByDesc('id')
                ->paginate(20);
            foreach ($data['orders'] as $index=>$order){
                $order->status_name  = __('api.'.$lang.'.orders.'.$order->status);
            }
            $apis->createApiResponse(false, 200, "  ", $data);
            return;
        }else{
            abort(404);
        }
    }

    public function show($id,Request $request){
        $apis = new ApiHelper();
        $user = $request->user('api');
        $lang = $request->header('lang');
        $client = Client::where('user_id',$user->id)->first();
        $order = Order::with('employee')->findOrFail($id);
        $items = OrderItem::with('product')
            ->where('order_id',$id)->get();
        if($client and $order->client_id == $client->id){
            $data['order']['id'] = $order->id;
            $data['order']['status'] = $order->status;
            $data['order']['total'] = $order->total;
            $data['order']['employee'] = ($order->employee) ? $order->employee->name : '';
            $data['order']['status_name']  = __('api.'.$lang.'.orders.'.$order->status);
            $data['items']  = array();
            foreach ($items as $index=>$item){
                $data['items'][$index]['id']  = $item->id;
                $data['items'][$index]['quantity']  = $item->quantity;
                $data['items'][$index]['product_name']  = ($item->product) ? $item->product->getTranslateName($lang) : '';
                $data['items'][$index]['product_price']  = ($item->product) ? $item->product->price : '';
            }

            $apis->createApiResponse(false, 200, "  ", $data);
            return;
        }else{
            abort(404);
        }
    }
}
