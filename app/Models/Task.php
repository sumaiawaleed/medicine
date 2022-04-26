<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name',
        'client_id',
        'sales_person_id',
        'location_id',
        'from_date',
        'to_date',
        'notes',
        'status'
    ];

    public function location(){
        return $this->belongsTo(Location::class,'location_id','id');
    }

    public function employee(){
        return $this->belongsTo(User::class,'sales_person_id','id');
    }


}
