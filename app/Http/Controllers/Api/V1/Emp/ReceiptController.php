<?php

namespace App\Http\Controllers\Api\V1\Emp;

use App\Functions\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReceiptController extends Controller
{
    private function validate_page($request, $data = "")
    {
        $rules =
            [
                'total' => 'required',
                'paid_amount' => 'required',
                'remind_amount' => 'required',
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

        $data['receipts'] = Receipt::where('invoice_id', $request->invoice_id)
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
                    'total' => $request->total,
                    'paid_amount' => $request->paid_amount,
                    'remind_amount' => $request->remind_amount,
                ];
                Receipt::create($request_data);
                $apis->createApiResponse(false, 200, __('api.' . $lang . '.added_successfully'), "");
            }
        }else{
            abort(404);
        }
    }
    public function update(Request $request, $id)
    {
        $receipt = Receipt::findOrFail($id);
        $apis = new ApiHelper();
        $user = $request->user('api');
        $lang = $request->header('lang');
        if ($user->type == 2) {
            $validator = $this->validate_page($request,$receipt);
            if ($validator->fails()) {
                return response()->json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()

                ), 200);
            } else {
                $request_data = [
                    'total' => $request->total,
                    'paid_amount' => $request->paid_amount,
                    'remind_amount' => $request->remind_amount,
                ];
                $receipt->update($request_data);
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
        $receipt = Receipt::findOrFail($id);
        $receipt->delete();
        $apis->createApiResponse(false, 200, __('api.' . $lang . '.delete_done'), "");
    }

}
