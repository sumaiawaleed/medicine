<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'title',
        'meta_title',
        'author',
        'facebook',
        'twitter',
        'linkedin',
        'email',
        'phone',
        'address',
        'meta_desc',
        'keywords',
        'terms'
    ];

    public function getTranslateTitle($local  = 'ar'){
        $name = "";
        try {
            $array = json_decode($this->title,TRUE);
            $name = $array[$local];
        }catch (\Exception $ex){

        }
        return $name;
    }

    public function getTranslateAddress($local  = 'ar'){
        $name = "";
        try {
            $array = json_decode($this->address,TRUE);
            $name = $array[$local];
        }catch (\Exception $ex){

        }
        return $name;
    }

    public function getTranslateTerm($local  = 'ar'){
        $name = "";
        try {
            $array = json_decode($this->terms,TRUE);
            $name = $array[$local];
        }catch (\Exception $ex){

        }
        return $name;
    }

    public function getTranslateDesc($local  = 'ar'){
        $name = "";
        try {
            $array = json_decode($this->meta_desc,TRUE);
            $name = $array[$local];
        }catch (\Exception $ex){

        }
        return $name;
    }

    public function getTranslateAuthor($local  = 'ar'){
        $name = "";
        try {
            $array = json_decode($this->author,TRUE);
            $name = $array[$local];
        }catch (\Exception $ex){

        }
        return $name;
    }

}
