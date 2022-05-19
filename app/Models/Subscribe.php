<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name',
        'description',
        'price',
        'period',
    ];

    public function getTranslateName($local  = 'ar'){
        $name = "";
        try {
            $array = json_decode($this->name,TRUE);
            $name = $array[$local];
        }catch (\Exception $ex){

        }
        return $name;
    }

    public function getTranslateDesc($local  = 'ar'){
        $name = "";
        try {
            $array = json_decode($this->description,TRUE);
            $name = $array[$local];
        }catch (\Exception $ex){

        }
        return $name;
    }
}
