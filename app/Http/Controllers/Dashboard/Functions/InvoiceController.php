<?php

namespace App\Http\Controllers\Dashboard\Functions;

use App\DataTables\Functions\InvoiceDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
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

    public function index(Request $request){
        $dataTable = new InvoiceDataTable(0,0,0);
        $data['title'] = __('site.invoices');
        return $dataTable->render('dashboard.functions.invoices.index',compact('data'));
    }

    private function validate_page($request , $data = "")
    {
        $rules =
            [
                'client_id' => 'required',
                'sales_person_id' => 'required',
                'order_id' =>  'required',
                'total' => 'required',
                'tax' => 'required',
                'notes' => 'required',
                'type' => 'required',
            ];
        $validator = Validator::make($request->all(), $rules);
        return $validator;
    }

    public function show($id){
        $form_data = Invoice::findOrFail($id);
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
           $request_data =[
               'client_id' => $request->client_id,
               'sales_person_id' => $request->sales_person_id,
               'order_id' => $request->order_id,
               'total' => $request->total,
               'tax' => $request->tax,
               'notes' => $request->notes,
               'type' => $request->type,
           ];
            Invoice::create($request_data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function edit($id)
    {
        $form_data = Invoice::findOrFail($id);
        $returnHTML = view('dashboard.functions.invoices.partials._edit',compact('form_data'))->render();
        return $returnHTML;
    }

    public function update(Request $request,$id)
    {
        $invoice = Invoice::findOrFail($request->id);
        $validator = $this->validate_page($request,$invoice);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {
            $request_data =[
                'client_id' => $request->client_id,
                'sales_person_id' => $request->sales_person_id,
                'order_id' => $request->order_id,
                'total' => $request->total,
                'tax' => $request->tax,
                'notes' => $request->notes,
                'type' => $request->type,
            ];
            $invoice->update($request_data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function remove($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
        return response()->json(array('success' => true));
    }
}
