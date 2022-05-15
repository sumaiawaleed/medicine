<?php

namespace App\Http\Controllers\Api\V1\Emp;

use App\Functions\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    private function validate_page($request, $data = "")
    {
        $rules =
            [
                'client_id' => 'required',
                'order_id' => 'required',
                'total' => 'required',
                'tax' => 'required',
                'notes' => 'required',
                'type' => 'required',
            ];
        $validator = Validator::make($request->all(), $rules);
        return $validator;
    }


    public function index(Request $request)
    {
        $apis = new ApiHelper();
        $lang = $request->header('lang');
        $user = $request->user('api');

        $data['invoices'] = Invoice::where('sales_person_id', $user->id)
            ->orderByDesc('id')
            ->paginate(20);
        foreach ($data['invoices'] as $index => $invoice) {
            $invoice->type_name = __('api.' . $lang . '.invoices.' . $invoice->type);
            $name = '';
            if ($invoice->getClient()) {
                $name = $invoice->getClient()->name;
            }
            $invoice->clients_name = $name;
        }
        $apis->createApiResponse(false, 200, "  ", $data);
        return;
    }

    private function check_amount($order_id, $total, $tax,$old_invoice = 0)
    {
        $invoices = '';
        if($old_invoice){
            $invoices =  Invoice::select(DB::raw('sum(total) as total_amount'), DB::raw('sum(tax) as tax_amount'))
                ->where('order_id', $order_id)
                ->where('id','!=', $old_invoice)
                ->first();
        }else{
            $invoices = Invoice::select(DB::raw('sum(total) as total_amount'), DB::raw('sum(tax) as tax_amount'))
                ->where('order_id', $order_id)
                ->first();
        }
        $order = Order::FindOrFail($order_id);
        if ($order->total <= ($invoices->total_amount + $invoices->tax_amount + $total + $tax)) {
            return false;
        }
        return true;
    }

    public function store(Request $request)
    {
        $apis = new ApiHelper();
        $user = $request->user('api');
        $lang = $request->header('lang');
        if ($user->type == 2) {
            $validator = $this->validate_page($request);
            if ($validator->fails()) {
                return response()->json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()

                ), 200);
            } else {

                $id_array = explode(__('site.total'), $request->order_id);
                $order_id = $id_array[0];
                if ($this->check_amount($order_id, $request->total, $request->tax)) {
                    $request_data = [
                        'client_id' => $request->client_id,
                        'sales_person_id' => $user->id,
                        'order_id' => $order_id,
                        'total' => $request->total,
                        'tax' => $request->tax,
                        'notes' => $request->notes,
                        'type' => $request->type,
                    ];
                    Invoice::create($request_data);
                    $apis->createApiResponse(false, 200, __('api.' . $lang . '.added_successfully'), "");
                    return;
                } else {
                    $apis->createApiResponse(false, 200, __('api.' . $lang . '.invoice_invalid'), "");
                    return;
                }

            }
        } else {
            abort(404);
        }
    }

    public function update($id,Request $request)
    {
        $invoice = Invoice::findOrFail($id);
        $apis = new ApiHelper();
        $user = $request->user('api');
        $lang = $request->header('lang');
        if ($user->type == 2) {
            $validator = $this->validate_page($request);
            if ($validator->fails()) {
                return response()->json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()

                ), 200);
            } else {

                $id_array = explode(__('site.total'), $request->order_id);
                $order_id = $id_array[0];
                if ($this->check_amount($order_id, $request->total, $request->tax,$id)) {
                    $request_data = [
                        'client_id' => $request->client_id,
                        'sales_person_id' => $user->id,
                        'order_id' => $order_id,
                        'total' => $request->total,
                        'tax' => $request->tax,
                        'notes' => $request->notes,
                        'type' => $request->type,
                    ];
                    $invoice->update($request_data);
                    $apis->createApiResponse(false, 200, __('api.' . $lang . '.updated_done'), "");
                    return;
                } else {
                    $apis->createApiResponse(false, 200, __('api.' . $lang . '.invoice_invalid'), "");
                    return;
                }

            }
        } else {
            abort(404);
        }
    }

    public function remove($id,Request $request)
    {
        $invoice = Invoice::findOrFail($id);
        $apis = new ApiHelper();
        $user = $request->user('api');
        $lang = $request->header('lang');
        $invoice->delete();
        $apis->createApiResponse(false, 200, __('api.' . $lang . '.delete_done'), "");
    }

}
