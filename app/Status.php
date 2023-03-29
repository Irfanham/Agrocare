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
    public function comments()
    {
        return $this->hasMany(Comment::class,'post_id');
    }

    public function reactions()
    {
        return $this->hasMany(Like::class,'post_id');
    }
}
