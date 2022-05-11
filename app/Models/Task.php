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
        'city_id',
        'area_id',
        'location',
        'lat',
        'log',
        'from_date',
        'to_date',
        'notes',
        'status'
    ];

    public function getStatusLable(){
        return '<lable class="badge bg-'.__('vars.tasks_colors.'.$this->status).'">'.__('vars.tasks.'.$this->status).'</lable>';
    }


    public function location(){
        return $this->belongsTo(Location::class,'location_id','id');
    }

    public function getClient(){
        $client = Client::find($this->client_id);
        $user = $client ? User::find($client->user_id) : '';
        return $user;
    }

    public function client(){
        return $this->belongsTo(Client::class,'client_id','id');
    }

    public function employee(){
        return $this->belongsTo(User::class,'sales_person_id','id');
    }

    public function getFromDateAttribute() {
        if(!$this->attributes['from_date'])
            return "";

        $date = $this->attributes['from_date'];
        return date('Y-m-d',strtotime($date));
    }

    public function getToDateAttribute() {
        if(!$this->attributes['to_date'])
            return "";

        $date = $this->attributes['to_date'];
        return date('Y-m-d',strtotime($date));
    }

}
