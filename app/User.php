<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','role_id','nohp','alamat','username','photo_profile', 'cover_photo' , 'password', 'status_ban',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function roles(){
        return $this->belongsTo(Role::class,'role_id');
    }
    public function posts(){
        return $this->hasMany(Post::class);
    }
    public function statuses(){
        return $this->hasMany(Status::class);
    }

    public function followers(){
        
            return $this->belongsToMany(self::class, 'friends', 'follow_id', 'user_id')->withTimestamps();
    }

    public function follows(){
        
        return $this->belongsToMany(self::class, 'friends', 'user_id', 'follow_id')->withTimestamps();

    }

    public function follow($userId){
        $this->follows()->attach($userId);
        return $this;
        
    }
    public function unfollow($userId){
        $this->follows()->dettach($userId);
        return $this;
    }
    public function isFollowing($userId){
        return (boolean) $this->follows()->where('follow_id',$userId)->first(['friends.id']);

    }



}
