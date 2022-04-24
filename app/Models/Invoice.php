<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'sales_person_id',
        'order_id',
        'total',
        'tax',
        'notes',
        'type',
    ];

    public function getClient(){
        $client  = Client::find($this->client_id);
        if($client){
            return User::find($client->user_id);
        }
        return  "";
    }

    public function employee(){
        return $this->belongsTo(User::class,'sales_person_id','id');
    }

    public function getCreatedAtAttribute() {
        if(!$this->attributes['created_at'])
            return "";

        $date = $this->attributes['created_at'];
        return date('Y-m-d',strtotime($date));
    }
}
