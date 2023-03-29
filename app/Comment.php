<?php

namespace App;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    // use HasFactory;

    protected $fillable = ['text','user_id','status_id'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function statuses()
    {
        return $this->belongsTo(Post::class,'status_id');
    }
}
