<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use App\Models\Ride;
use Illuminate\Support\Collection;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        return view("index");
    }

    public function home()
    {
        $rideCount = Ride::all()->count();
        $rides = Ride::all();

        $terminatedRidesCount = Ride::where("status_id", Status::where("code", "TER")->first()->id)->count();

        $mostCommonRide = Ride::select('to')
            ->groupBy('to')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(5)
            ->get();

        $onGoingRides = Ride::where("status_id", Status::where("code", "ENC")->first()->id);
        $drivers = User::whereHas('role', function ($query) {
            $query->where('roles.code', 'DRI');
        })->get();

        $occupated_drivers = new Collection();
        foreach($drivers as $driver){
            $activeRides = Ride::where("driver_id", $driver->id)->where("status_id", Status::where("code", "ENC")->first()->id)->count();
            if($activeRides > 0){
                $occupated_drivers->add($driver);
            }
        }

        $activeCustomers = User::whereHas('role', function ($query) {
            $query->where('roles.code', 'CLI');
        })->get();

        $activeCount = 0;

        $totalUsers = User::whereHas('role', function ($query) {
            $query->where('roles.code', 'CLI');
        })->count();

        foreach($onGoingRides as $ride){
            foreach($activeCustomers as $customer){
                if($customer->id == $ride->client_id) $activeCount++;
            }
        }

        return view("home", compact("rideCount", "terminatedRidesCount", "rides", "totalUsers","mostCommonRide", "onGoingRides", "drivers", "occupated_drivers", "activeCount"));
    }
}
