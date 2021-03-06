<?php

namespace App\Http\Controllers\Dashboard\People;

use App\DataTables\Functions\ClientFinAccountDataTable;
use App\DataTables\Functions\InvoiceDataTable;
use App\DataTables\Functions\OrderDataTable;
use App\DataTables\Functions\TaskDataTable;
use App\DataTables\People\UserLocationDataTable;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientFunController extends Controller
{
    public function orders($id){
        $data['page'] = 'orders';
        $form_data = User::findOrFail($id);
        $client = Client::where('user_id',$id)->first();
        if($form_data->type != 3){
            abort(404);
        }
        $data['emp'] = $form_data;
        $data['title'] = $form_data->name.' '.__('site.orders');
        $data['user'] = $form_data;
        $data['orders'] = Order::where('client_id',$client->id)->count();
        $data['tasks'] = Task::where('client_id',$client->id)->count();
        $data['invoices'] = Invoice::where('client_id',$client->id)->count();
        $dataTable = new OrderDataTable($client->id,0);
        return $dataTable->render('dashboard.people.clients.functions._orders',compact('data'));
    }

    public function invoices($id){
        $data['page'] = 'invoices';
        $form_data = User::findOrFail($id);
        $client = Client::where('user_id',$id)->first();
        if($form_data->type != 3){
            abort(404);
        }
        $data['emp'] = $form_data;
        $data['title'] = $form_data->name.' '.__('site.invoices');
        $data['user'] = $form_data;
        $data['orders'] = Order::where('client_id',$client->id)->count();
        $data['tasks'] = Task::where('client_id',$client->id)->count();
        $data['invoices'] = Invoice::where('client_id',$client->id)->count();
        $dataTable = new InvoiceDataTable($client->id,0,0);
        return $dataTable->render('dashboard.people.clients.functions._invoices',compact('data'));
    }



    public function tasks($id){
        $data['page'] = 'tasks';
        $form_data = User::find($id);
        $client = Client::where('user_id',$id)->first();
        if($form_data->type != 3){
            abort(404);
        }
        $data['emp'] = $form_data;
        $data['title'] = $form_data->name.' '.__('site.tasks');
        $data['user'] = $form_data;
        $data['orders'] = Order::where('client_id',$client->id)->count();
        $data['tasks'] = Task::where('client_id',$client->id)->count();
        $data['invoices'] = Invoice::where('client_id',$client->id)->count();
        $dataTable = new TaskDataTable($client->id,0);
        return $dataTable->render('dashboard.people.clients.functions._tasks',compact('data'));
    }

    public function locations($id){
        $data['page'] = 'locations';
        $form_data = User::findOrFail($id);
        $client = Client::where('user_id',$id)->first();
        if($form_data->type != 3){
            abort(404);
        }
        $data['emp'] = $form_data;
        $data['title'] = $form_data->name.' '.__('site.locations');
        $data['user'] = $form_data;
        $data['orders'] = Order::where('client_id',$client->id)->count();
        $data['tasks'] = Task::where('client_id',$client->id)->count();
        $data['invoices'] = Invoice::where('client_id',$client->id)->count();
        $dataTable = new UserLocationDataTable($form_data->id);
        return $dataTable->render('dashboard.people.clients.functions._locations',compact('data'));
    }

    public function financial($id,Request $request){
        $data['page'] = 'financial';
        $form_data = User::findOrFail($id);
        $client = Client::where('user_id',$id)->first();
        if($form_data->type != 3){
            abort(404);
        }
        $data['emp'] = $form_data;
        $data['client'] = $client;
        $data['title'] = $form_data->name.' '.__('site.client_fin_accounts');
        $data['user'] = $form_data;
        $data['orders'] = Order::where('client_id',$client->id)->count();
        $data['tasks'] = Task::where('client_id',$client->id)->count();
        $data['invoices'] = Invoice::where('client_id',$client->id)->count();
        $dataTable = new ClientFinAccountDataTable($client->id);
        return $dataTable->render('dashboard.people.clients.functions._client_fin_accounts',compact('data'));
    }

    public function add_subscribe(Request $request){
        $client = Client::where('user_id',$request->add_sub_id)->first();
        if(!$client){
            abort(404);
        }
        $rules = [
            'add_sub_id' => 'required',
            'add_subscribe_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {
            $request_data = [
                'subscribe_id' => $request->add_subscribe_id,
                'subscribe_date' => now(),
                'subscribe_status' => 1,
            ];
            $client->update($request_data);
            return response()->json(array('success' => true), 200);
        }

    }

    public function cancel_subscribe(Request $request){
        $client = Client::where('user_id',$request->id)->first();
        if(!$client){
            abort(404);
        }

        $request_data = [
            'subscribe_id' => 0,
            'subscribe_date' => null,
            'subscribe_status' => 0,
        ];
        $client->update($request_data);
        return response()->json(array('success' => true), 200);

    }

}
