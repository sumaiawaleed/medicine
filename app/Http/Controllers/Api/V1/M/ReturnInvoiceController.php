<?php

namespace App\Http\Controllers\Api\V1\M;

use App\Functions\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\ReturnInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReturnInvoiceController extends Controller
{
    private function validate_page($request, $data = "")
    {
        $rules =
            [
                'amount'  => 'required',
                'notes' => 'required',
            ];
        if(!$data){
            $rules += [
                'invoice_id'  => 'required',
            ];
        }
        $validator = Validator::make($request->all(), $rules);
        return $validator;
    }

    public function index(Request $request)
    {
        $apis = new ApiHelper();
        $lang = $request->header('lang');
        $user = $request->user('api');

        $data['return_invoices'] = ReturnInvoice::where('invoice_id', $request->invoice_id)
            ->orderByDesc('id')
            ->paginate(20);
        $apis->createApiResponse(false, 200, "  ", $data);
        return;
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
                $request_data = [
                    'invoice_id' => $request->invoice_id,
                    'amount' => $request->amount,
                    'notes' => $request->notes,
                ];
                ReturnInvoice::create($request_data);
                $apis->createApiResponse(false, 200, __('api.' . $lang . '.added_successfully'), "");
            }
        }else{
            abort(404);
        }
    }
    public function update(Request $request, $id)
    {
        $return_invoice = Invoice::findOrFail($id);
        $apis = new ApiHelper();
        $user = $request->user('api');
        $lang = $request->header('lang');
        if ($user->type == 2) {
            $validator = $this->validate_page($request,$return_invoice);
            if ($validator->fails()) {
                return response()->json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()

                ), 200);
            } else {
                $request_data = [
                    'amount' => $request->amount,
                    'notes' => $request->notes,
                ];
                $return_invoice->update($request_data);
                $apis->createApiResponse(false, 200, __('api.' . $lang . '.updated_done'), "");
            }
        }else{
            abort(404);
        }
    }

    public function destroy($id,Request $request)
    {
        $apis = new ApiHelper();
        $user = $request->user('api');
        $lang = $request->header('lang');
        $return_invoice = ReturnInvoice::findOrFail($id);
        $return_invoice->delete();
        $apis->createApiResponse(false, 200, __('api.' . $lang . '.delete_done'), "");
    }
}
