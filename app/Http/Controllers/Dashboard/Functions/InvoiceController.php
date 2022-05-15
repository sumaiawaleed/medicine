<?php

namespace App\Http\Controllers\Dashboard\Functions;

use App\DataTables\Functions\InvoiceDataTable;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class InvoiceController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:invoices-read'])->only('index', 'show');
        $this->middleware(['permission:invoices-create'])->only('create', 'store');
        $this->middleware(['permission:invoices-update'])->only('edit', 'update');
        $this->middleware(['permission:invoices-delete'])->only('destroy');
    }//end of constructor

    public function index(Request $request)
    {
        $client_id = ($request->client_id) ? $request->client_id : 0;
        $emp_id = ($request->client_id) ? $request->client_id : 0;
        $order_id = ($request->order_id) ? $request->order_id : 0;
        $dataTable = new InvoiceDataTable($client_id, $emp_id, $order_id);
        $data['title'] = __('site.invoices');
        if($request->order_id){
            $data['order'] = Order::with('employee')->findOrFail($request->order_id);
        }
        return $dataTable->render('dashboard.functions.invoices.index', compact('data'));
    }

    private function validate_page($request, $data = "")
    {
        $rules =
            [
                'client_id' => 'required',
                'sales_person_id' => 'required',
                'order_id' => 'required',
                'total' => 'required',
                'tax' => 'required',
                'notes' => 'required',
                'type' => 'required',
            ];
        $validator = Validator::make($request->all(), $rules);
        return $validator;
    }

    public function show($id)
    {
        $form_data = Invoice::findOrFail($id);
        return json_encode($form_data);
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
                    'sales_person_id' => $request->sales_person_id,
                    'order_id' => $order_id,
                    'total' => $request->total,
                    'tax' => $request->tax,
                    'notes' => $request->notes,
                    'type' => $request->type,
                ];
                Invoice::create($request_data);
                return response()->json(array('success' => true), 200);

            } else {
                return response()->json(array(
                    'success' => 3,
                    'msg' => __('site.invoice_invalid')

                ), 200);
            }

        }
    }

    public function edit($id)
    {
        $form_data = Invoice::findOrFail($id);
        $data['order'] = Order::FindOrFail($form_data->order_id);
        $data['client'] = Client::with('user')->find($form_data->client_id);
        $data['emp'] = User::find($form_data->sales_person_id);

        $returnHTML = view('dashboard.functions.invoices.partials._edit', compact('form_data','data'))->render();
        return $returnHTML;
    }

    public function update(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($request->id);
        $validator = $this->validate_page($request);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {

            $id_array = explode(__('site.total'), $request->order_id);
            $order_id = $id_array[0];
            if ($this->check_amount($order_id, $request->total, $request->tax,$invoice->id)) {
                $request_data = [
                    'client_id' => $request->client_id,
                    'sales_person_id' => $request->sales_person_id,
                    'order_id' => $order_id,
                    'total' => $request->total,
                    'tax' => $request->tax,
                    'notes' => $request->notes,
                    'type' => $request->type,
                ];
                $invoice->update($request_data);
                return response()->json(array('success' => true), 200);

            } else {
                return response()->json(array(
                    'success' => 3,
                    'msg' => __('site.invoice_invalid')

                ), 200);
            }
        }
    }

    public function remove($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
        return response()->json(array('success' => true));
    }
}
