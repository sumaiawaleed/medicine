<?php

namespace App\Models;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnInvoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_id',
        'amount',
        'notes'
    ];
    public function invoice(){
        return $this->belongsTo(Invoice::class,'invoice_id','id');
    }

}
