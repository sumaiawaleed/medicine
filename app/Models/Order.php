<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'sales_person_id',
        'total',
        'status'
    ];

    public function getStatusLable(){
        return '<lable class="badge bg-'.__('vars.order_colors.'.$this->status).'">'.__('vars.orders.'.$this->status).'</lable>';
    }

    public function getClient(){
        $client  = Client::find($this->client_id);
        if($client){
            return User::find($client->user_id);
        }
        return  "";
    }

    public function client(){
        return $this->belongsTo(Client::class,'client_id','id');
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
