<?php

namespace App\Http\Controllers\Dashboard\Functions;

use App\DataTables\Functions\ReceiptDataTable;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReceiptController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:receipts-read'])->only('index', 'show');
        $this->middleware(['permission:receipts-create'])->only('create', 'store');
        $this->middleware(['permission:receipts-update'])->only('edit', 'update');
        $this->middleware(['permission:receipts-delete'])->only('destroy');
    }//end of constructor

    public function index(Request $request)
    {
        $dataTable = new ReceiptDataTable($request->invoice_id);
        $data['title'] = __('site.receipts');
        $data['invoice'] = Invoice::findOrFail($request->invoice_id);
        return $dataTable->render('dashboard.functions.receipts.index', compact('data'));
    }

    private function validate_page($request, $data = "")
    {
        $rules =
            [
                'invoice_id'  => 'required',
                'total' => 'required',
                'paid_amount' => 'required',
                'remind_amount' => 'required',
            ];
        $validator = Validator::make($request->all(), $rules);
        return $validator;
    }

    public function show($id)
    {
        $form_data = Receipt::findOrFail($id);
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
                'total' => $request->total,
                'paid_amount' => $request->paid_amount,
                'remind_amount' => $request->remind_amount,
            ];
            Receipt::create($request_data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function edit($id)
    {
        $form_data = Receipt::findOrFail($id);
        $returnHTML = view('dashboard.functions.receipts.partials._edit', compact('form_data'))->render();
        return $returnHTML;
    }

    public function update(Request $request, $id)
    {
        $receipt = Receipt::findOrFail($request->id);
        $validator = $this->validate_page($request);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ), 200);
        } else {
            $request_data = [
                'invoice_id' => $request->invoice_id,
                'total' => $request->total,
                'paid_amount' => $request->paid_amount,
                'remind_amount' => $request->remind_amount,
            ];
            $receipt->update($request_data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function remove($id)
    {
        $receipt = Receipt::findOrFail($id);
        $receipt->delete();
        return response()->json(array('success' => true));
    }
}
