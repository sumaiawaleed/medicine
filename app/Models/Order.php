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

    public function client(){
        return $this->belongsTo(Client::class,'client_id','id');
    }

    public function employee(){
        return $this->belongsTo(User::class,'sales_person_id','id');
    }
}
