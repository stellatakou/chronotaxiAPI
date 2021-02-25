<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ["client_id", "driver_id", "note", "body"];

    public function driver(){
        return $this->belongsTo(User::class, "driver_id");
    }

    public function client(){
        return $this->belongsTo(User::class, "client_id");
    }
}
