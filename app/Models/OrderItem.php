<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'product_id',
        'order_id',
        'quantity',
        'unit_id',
    ];

    public function product(){
        return $this->belongsTo(Product::class,'product_id','id');
    }

    public function unit(){
        return $this->belongsTo(ProductUnit::class,'unit_id','id');
    }

    public function order(){
        return $this->belongsTo(Order::class,'order_id','id');
    }
}
