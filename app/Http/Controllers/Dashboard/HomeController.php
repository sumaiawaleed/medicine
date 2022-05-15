<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(){
        $data['title'] = __('site.home');
        $data['orders'] = Order::count();
        $data['latest_orders'] = Order::with('employee')->orderByDesc('id')->get()->take(10);
        $data['invoices'] = Invoice::count();
        $data['tasks'] = Task::count();
        $data['p_tasks'] = Task::where('status',1)->get()->take(10);
        $data['clients'] = Client::count();
        $data['latest_clients'] = User::where('type',3)->orderByDesc('id')->get()->take(10);
        $data['top_emps'] = Order::select(DB::raw('count("orders.id") as total_orders'),'users.*')
            ->join('users','users.id','=','orders.sales_person_id')
            ->groupBy('sales_person_id')
            ->orderBy('total_orders')
            ->get()->take(10);

        $data['top_products'] = OrderItem::select('order_items.*',DB::raw('count("order_items.id") as total_orders'))
            ->groupBy('product_id')
            ->orderBy('total_orders')
            ->get()->take(10);
        foreach ($data['top_products'] as $p){
            $p->product = Product::find($p->product_id);
        }
        return view('dashboard.index', compact('data'));
    }
}
