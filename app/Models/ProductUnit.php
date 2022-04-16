<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductUnit extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'unit_id',
        'product_id',
        'price',
        'quantity',
    ];

    public function getTranslateName($locale = 'ar'){
        return __('vars.units.'.$this->unit_id);
    }
    public function product(){
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
