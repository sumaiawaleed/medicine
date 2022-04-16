<?php


namespace App\Functions;


use App\Models\Client;
use App\Models\Engineer;
use App\Models\Order;
use App\Models\OrderVat;

class FcmNotification
{
    private $server_key = 'AAAAlqEnETI:APA91bH_8_N9YUl8B_wJeLbhdjAgANRnEVRWusFfYOltOq15GroLmgekz2BLpP6v2OPFY1rcWo0NaD9BarV_ziGKXOoezvpYeYmF6ZrLywBxcipOO4sUCn49zfjj6IveSvEVWvVDMBce';

    public function new_order($id)
    {
        $order = Order::find($id);
        $this->send_notification(
            'new order',
            'you have a new order',
            'admin',
            $id);

        if ($order->store_id) {
            $eng = Engineer::where('store_id', $order->store_id)->get()->first();
            if ($eng) {
                $this->send_notification(
                    'new order',
                    'you have a new order',
                    $eng->phone,
                    $id);
            }
        }
    }

    public function change_order_status($id){
        $order = Order::find($id);
        if($order->client_id){
            $client = Client::find($order->client_id);
            if($client){
                $this->send_notification(
                    'order track',
                    'your order is '.__('vars.orders.'.$order->status),
                    $client->phone,
                    $id);
            }
        }

    }

    public function new_vat_order($id, $store_id){
        $order = Order::find($id);
        $vat = OrderVat::where('order_id',$id)->get()->first();
        $msg = 'you have a new order ';
        if($vat){
            $msg .= 'in'.substr($vat->start_date,0,10).' at '.$vat->start_time;
        }
        $this->send_notification(
            'new order',
            $msg,
            'admin',
            $id);

        if ($order->store_id) {
            $eng = Engineer::where('store_id', $order->store_id)->get()->first();
            if ($eng) {
                $this->send_notification(
                    'new order',
                    $msg,
                    $eng->phone,
                    $id);
            }
        }
    }

    public function re_vat_order($id, $old_store, $store_id){
        if($old_store != $store_id){
            $old = Engineer::where('store_id',$old_store)->get()->first();
            if($old){
                $this->send_notification(
                    'order cancel',
                    'the client cancel his visit to your store',
                    $old->phone,
                    $id);
            }

            $eng = Engineer::where('store_id', $store_id)->get()->first();
            if ($eng) {
                $vat = OrderVat::where('order_id',$id)->get()->first();
                $msg = 'you have a new order ';
                if($vat){
                    $msg .= 'in'.substr($vat->start_date,0,10).' at '.$vat->start_time;
                }
                $this->send_notification(
                    'new order',
                    $msg,
                    $eng->phone,
                    $id);
            }
        }
    }

    public function send_notification($title, $message, $topic, $order_id = 0)
    {
        define('API_ACCESS_KEY', $this->server_key);
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

        $notification = [
            'title' => $title,
            'body' => $message,
            'order_id' => $order_id,
            'icon' => 'myIcon',
            'sound' => 'mySound'
        ];
        $extraNotificationData = ["message" => $notification, "moredata" => 'dd'];

        $fcmNotification = [
            //'registration_ids' => $tokenList, //multple token array
            'to' => '/topics/' . $topic, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];

        $headers = [
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);
        return true;
    }
}
