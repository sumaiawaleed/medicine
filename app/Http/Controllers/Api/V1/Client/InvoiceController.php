<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Functions\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $apis = new ApiHelper();
        $lang = $request->header('lang');
        $user = $request->user();
        $invoices = Invoice::when($request->order_id, function ($q) use ($request) {
            return $q->where('order_id', '=', $request->order_id);
        })->where('client_id', $user->id)->orderByDesc('id')
            ->paginate(20);
        $data['invoices'] = array();
        foreach ($invoices as $index => $invoice) {
            $data['invoices'][$index]['id'] = $invoice->id;
            $data['invoices'][$index]['order_id'] = $invoice->order_id;
            $data['invoices'][$index]['total'] = $invoice->total;
            $data['invoices'][$index]['tax'] = $invoice->tax;
            $data['invoices'][$index]['notes'] = $invoice->notes;
            $data['invoices'][$index]['type'] = $invoice->type;
            $data['invoices'][$index]['type_name'] = __('api.' . $lang . '.types.' . $invoice->type);
            $data['invoices'][$index]['created_at'] = $invoice->created_at;
        }
        $apis->createApiResponse(false, 200, "  ", $data);
        return;
    }
}
