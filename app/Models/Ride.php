<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    protected $fillable = [
		"latitude",
		"longitude",
		"from",
		"to",
		"client_id",
        "type_id",
        "price",
        "toLongitude",
        "toLatitude"
    ];

    protected $with = ["client", "type", "driver", "status"];

    public function driver(){
        return $this->belongsTo(User::class, "driver_id");
    }

    public function status(){
        return $this->belongsTo(Status::class);
    }

    public function client(){
        return $this->belongsTo(User::class, "client_id");
    }

    public function type(){
        return $this->belongsTo(RideType::class, "type_id");
    }
}
