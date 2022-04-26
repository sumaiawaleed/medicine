<?php

namespace App\Models;

use App\Functions\ImagesFunctions;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'image',
        'type',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['image_path'];

    public function getImagePathAttribute(){
        if($this->image)
            return  asset('public/uploads/users/'.$this->image);
        else
            return  asset('public/uploads/users/placeholder.png');
    }

    public function getImageSize($size_width, $size_height)
    {
        $image =  asset('public/uploads/users/' . $this->image);
        if($image!=''){
            $image = str_replace(asset('public/uploads/users').'/', '', $image);
            if(strpos($image, 'placeholder.png')){
                return $image;
            }
            $images_functions = new ImagesFunctions();
            $new_image = $images_functions->getNewSizeFromImage('users', $image, $size_width, $size_height);
            if($new_image!=''){
                return asset('public/uploads/users/' . $new_image);
            } else {
                return asset('public/uploads/photo.svg');
            }
        } else {
            return asset('public/uploads/photo.svg');
        }
    }//end of image path attribute

    public function client(){
        return $this->hasOne(Client::class,'user_id','id');
    }
}
