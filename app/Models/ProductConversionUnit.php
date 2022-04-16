<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductConversionUnit extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'product_id',
        'from_id',
        'to_id',
        'unit_id',
    ];

    public function product(){
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
