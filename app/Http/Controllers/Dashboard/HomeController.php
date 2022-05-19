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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

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

    public function profile(){
        $data['title'] = __('site.my_profile');
        return view('dashboard.user.profile', compact('data'));
    }

    public function update_profile (Request $request){
        $user = Auth()->user();
        $rules = [
            'name' => 'required',
            'email' => [ 'required','email',
                Rule::unique('users')->ignore($user->id, 'id')
            ],
        ];

        $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {
            $data['name'] = $request->name;
            $data['email'] = $request->email;

            if ($request->image) {

                Image::make($request->image)
                    ->save(public_path('uploads/users/' . $request->image->hashName()));

                $data['image'] = $request->image->hashName();

            }//end of if

            $user->update($data);

            return response()->json(array('success' => true), 200);
        }
    }

    public function change_password(Request $request){
        $user = Auth()->user();
        $rules = [
            'password' => 'required|string|min:6|confirmed',
            'old_password'=> 'required|string|min:6',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        }

        $oldpassword = $request->input('old_password');
        if (!Hash::check($oldpassword,$user->password)) {
            //اذا كانت كلمة المرور الحالية غلط
        }

        $user->password = Hash::make($request['password']);
        $user->save();
        return response()->json(array('success' => true), 200);
    }
}
