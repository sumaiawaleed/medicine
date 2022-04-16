<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'type_id',
    ];

    protected $appends = ['type_name'];
    public function getTypeNameAttribute(){
        $type = ClientType::find($this->type_id);
        return $type ? $type->getTranslateName(app()->getLocale()) : '';
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function type(){
        return $this->belongsTo(ClientType::class,'type_id','id');
    }
}
