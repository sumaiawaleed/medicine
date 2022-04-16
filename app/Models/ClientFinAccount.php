<?php

namespace App;

use App\Models\Client;
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
}
