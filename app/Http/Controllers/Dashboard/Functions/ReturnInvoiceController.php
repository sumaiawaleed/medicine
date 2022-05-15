<?php

namespace App\Http\Controllers\Dashboard\Functions;

use App\DataTables\Functions\ReturnInvoiceDataTable;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\ReturnInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReturnInvoiceController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:return_invoices-read'])->only('index', 'show');
        $this->middleware(['permission:return_invoices-create'])->only('create', 'store');
        $this->middleware(['permission:return_invoices-update'])->only('edit', 'update');
        $this->middleware(['permission:return_invoices-delete'])->only('destroy');
    }//end of constructor

    public function index(Request $request)
    {
        $dataTable = new ReturnInvoiceDataTable($request->invoice_id);
        $data['title'] = __('site.return_invoices');
        $data['invoice'] = Invoice::findOrFail($request->invoice_id);
        return $dataTable->render('dashboard.functions.return_invoices.index', compact('data'));
    }

    private function validate_page($request, $data = "")
    {
        $rules =
            [
                'invoice_id'  => 'required',
                'amount'  => 'required',
                'notes' => 'required',
            ];
        $validator = Validator::make($request->all(), $rules);
        return $validator;
    }

    public function show($id)
    {
        $form_data = ReturnInvoice::findOrFail($id);
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
            $request_data = [
                'invoice_id' => $request->invoice_id,
                'amount' => $request->amount,
                'notes' => $request->notes,
            ];
            ReturnInvoice::create($request_data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function edit($id)
    {
        $form_data = ReturnInvoice::findOrFail($id);
        $returnHTML = view('dashboard.functions.return_invoices.partials._edit', compact('form_data'))->render();
        return $returnHTML;
    }

    public function update(Request $request, $id)
    {
        $return_invoice = Invoice::findOrFail($request->id);
        $validator = $this->validate_page($request);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {

            $id_array = explode(__('site.total'), $request->order_id);
            $order_id = $id_array[0];
            if ($this->check_amount($order_id, $request->total, $request->tax,$return_invoice->id)) {
                $request_data = [
                    'client_id' => $request->client_id,
                    'sales_person_id' => $request->sales_person_id,
                    'order_id' => $order_id,
                    'total' => $request->total,
                    'tax' => $request->tax,
                    'notes' => $request->notes,
                    'type' => $request->type,
                ];
                $return_invoice->update($request_data);
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
        $return_invoice = ReturnInvoice::findOrFail($id);
        $return_invoice->delete();
        return response()->json(array('success' => true));
    }
}
