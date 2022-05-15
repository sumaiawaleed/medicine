<?php

namespace App\Http\Controllers\Dashboard\People;

use App\DataTables\Functions\ClientFinAccountDataTable;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ClientFinAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FinAccountController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:client_fin_accounts-read'])->only('index', 'show');
        $this->middleware(['permission:client_fin_accounts-create'])->only('create', 'store');
        $this->middleware(['permission:client_fin_accounts-update'])->only('edit', 'update');
        $this->middleware(['permission:client_fin_accounts-delete'])->only('destroy');
    }//end of constructor

    public function index(Request $request)
    {
        $data['client'] = Client::where('user_id',$request->client_id)->first();
        if(!$data['client']){
            abort(404);
        }
        $dataTable = new ClientFinAccountDataTable($data['client']->id);
        $data['title'] = __('site.client_fin_accounts');
        return $dataTable->render('dashboard.functions.client_fin_accounts.index', compact('data'));
    }

    private function validate_page($request, $data = "")
    {
        $rules =
            [
                'client_id'  => 'required',
                'total_amount' => 'required',
                'paid_amount' => 'required',
                'remind_amount' => 'required',
            ];
        $validator = Validator::make($request->all(), $rules);
        return $validator;
    }

    public function show($id)
    {
        $form_data = ClientFinAccount::findOrFail($id);
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
                'client_id' => $request->client_id,
                'total_amount' => $request->total_amount,
                'paid_amount' => $request->paid_amount,
                'remind_amount' => $request->remind_amount,
            ];
            ClientFinAccount::create($request_data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function edit($id)
    {
        $form_data = ClientFinAccount::findOrFail($id);
        $returnHTML = view('dashboard.functions.client_fin_accounts.partials._edit', compact('form_data'))->render();
        return $returnHTML;
    }

    public function update(Request $request, $id)
    {
        $fin_account = ClientFinAccount::findOrFail($request->id);
        $validator = $this->validate_page($request);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ), 200);
        } else {
            $request_data = [
                'client_id' => $request->client_id,
                'total_amount' => $request->total_amount,
                'paid_amount' => $request->paid_amount,
                'remind_amount' => $request->remind_amount,
            ];
            $fin_account->update($request_data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function remove($id)
    {
        $fin_account = ClientFinAccount::findOrFail($id);
        $fin_account->delete();
        return response()->json(array('success' => true));
    }
}
