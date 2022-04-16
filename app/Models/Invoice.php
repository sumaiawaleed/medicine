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

    public function getCreatedAtAttribute() {
        if(!$this->attributes['created_at'])
            return "";

        $date = $this->attributes['created_at'];
        return date('Y-m-d',strtotime($date));
    }
}
