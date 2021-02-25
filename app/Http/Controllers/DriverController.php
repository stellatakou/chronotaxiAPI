<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Helpers\Helper;
use Illuminate\Support\Collection;
use App\Models\Ride;
use App\Models\RideStatus;
use App\Models\Status;

class DriverController extends Controller
{
    public function store()
    { }

    public function index()
    {
        return User::whereHas('role', function ($query) {
            $query->where('roles.code', 'DRI');
        })->where("activated", "1")->get();
    }

    public function show($id){
        return User::where("activated", "1")->get();
    }

    public function find(Request $request)
    {
        $this->validate($request, [
            "latitude"      => "required",
            "longitude"     => "required",
        ]);
        $drivers = User::with("reviews")->whereHas('role', function ($query) {
            $query->where('roles.code', 'DRI');
        })->get();
        $found_drivers = new Collection();
        foreach($drivers as $driver){
            $average = $driver->reviews->avg("note");
            $driver->average = $average;
            $driverPosition = array(
                'latitude' => $driver->latitude,
                'longitude' => $driver->longitude
            );
            $distance = floor(Helper::getDistance($request->input("latitude"), $request->input("longitude"), $driverPosition['latitude'], $driverPosition['longitude'])['kilometers']);
            if($distance <= /*$request->distance ??*/ 150){
                $found_drivers->add($driver);
            }
        }

        return response()->json($found_drivers);
    }

	public function update(Request $request, $id){
		$user = User::findOrFail($id);
		$user->fill($request->all());
		$user->save();
		return response()->json($user);
	}

    public function command(Request $request){
        $this->validate($request, [
            "client_id"     => "required",
            "from"          => "required",
            "to"            => "required",
        ]);

        $ride = new Ride();
        $ride->client_id = $request->user()->id;
        $ride->from = $request->from;
        $ride->to = $request->to;
        $ride->save();

        $ride_status = new RideStatus();
        $ride_status->client_id = $ride->client_id;
        $ride_status->status_id = Status::where("code", "PEN")->first()->id;
        $ride_status->save();

        return response()->json($ride);
    }
}
