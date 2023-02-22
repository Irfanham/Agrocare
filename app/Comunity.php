<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comunity extends Model
{
    //
    public function status(){
        return $this->belongsTo(Status::class,'status_id');
    }

}
