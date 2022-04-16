<?php


namespace App\Functions;


use App\Models\Client;
use App\Models\Engineer;
use App\Models\Store;

class ApiHelper
{
    public static function createApiResponse($is_error,$code,$message,$content){
        $data['success'] = $is_error ? "false" : "true";
//        $data['code'] = $code;
        $data['message'] = $message;
        $data['content'] = $content;

        echo json_encode($data, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK );
    }

    public function get_client($token){
        return Client::select( 'id','first_name','last_name','image','phone','email','gender','status','verify_status')->where('is_deleted',0)->where('api_token',$token)->get()->first();
    }

    public function client($id){
        return Client::select( 'id','first_name','last_name','image','phone','email','gender','status','verify_status','api_token')->where('is_deleted',0)->where('id',$id)->get()->first();
    }

    public function get_engineer($token){
        return Engineer::select( 'id','first_name','last_name','image','phone','email','gender','status','verify_status','api_token','store_id')->where('is_deleted',0)->where('api_token',$token)->get()->first();
    }

    public function engineer($id){
        return Engineer::select( 'id','first_name','last_name','image','phone','email','gender','status','verify_status','api_token','store_id')->where('is_deleted',0)->where('id',$id)->get()->first();
    }

    public function store($id){
        return Store::select( 'name',
            'image',
            'phone',
            'email',
            'address',
            'lat',
            'log',
            'status',
        )->where('is_deleted',0)->where('id',$id)->get()->first();
    }
}
