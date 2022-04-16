<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'name',
        'expire_date',
        'is_available',
        'image',
        'notes',
        'scientific_name',
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

    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function get_category_name($local = 'ar'){
        $category = Category::find($this->category_id);
        return $category ? $category->getTranslateName($local) : '';
    }

    public function getExpireDateAttribute() {
        if(!$this->attributes['expire_date'])
            return "";

        $date = $this->attributes['expire_date'];
        return date('Y-m-d',strtotime($date));
    }

    protected $appends = ['image_path'];

    public function getImagePathAttribute()
    {
        if( $this->image)
            return asset("public/uploads/products/" . $this->image);
        else
            return asset('public/uploads/photo.svg');
    }


    public function getAvailableLabel(){
        if($this->is_available == 1){
            return '<span class="badge badge-success">'.__('site.yes').'</span>';
        }elseif($this->is_available == 0){
            return '<span class="badge badge-danger">'.__('site.no').'</span>';
        }
    }

}
