<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientFinAccount extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'total_amount',
        'paid_amount',
        'remind_amount',
    ];

    public function client(){
        return $this->belongsTo(Client::class,'client_id','id');
    }
    public function getClient(){
        $client  = Client::find($this->client_id);
        if($client){
            return User::find($client->user_id);
        }
        return  "";
    }
}
