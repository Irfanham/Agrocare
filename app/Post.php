<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $fillable = [
        'title', 'user_id','content'
    ];
    public function users(){
        return $this->belongsTo(User::class,'user_id');
    }

}
