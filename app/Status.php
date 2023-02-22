<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    //
    protected $fillable = [
        'user_id','content','image','file',
    ];
    public function users(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function community(){
        return $this->hasMany(Comunity::class);
    }
}
