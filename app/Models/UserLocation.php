<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLocation extends Model
{
    use HasFactory;
    protected $table = "user_locations";
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'city_id',
        'area_id',
        'location',
        'is_current',
    ];


    public function getTranslateName($local  = 'ar'){
        $name = "";
        try {
            $array = json_decode($this->location,TRUE);
            $name = $array[$local];
        }catch (\Exception $ex){

        }
        return $name;
    }

    public function city(){
        return $this->belongsTo(City::class,'city_id','id');
    }

    public function area(){
        return $this->belongsTo(Area::class,'area_id','id');
    }
}
