<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Helpers\Helper;
use Illuminate\Support\Collection;
use App\Models\Ride;
use App\Models\RideType;
use App\Models\RideStatus;
use App\Models\Status;
use GuzzleHttp\Client;
use function GuzzleHttp\json_encode;

class RidesController extends Controller
{
    public function index()
    {
        return response()->json(Ride::all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            "latitude" => "required",
            "longitude" => "required",
            "from" => "required",
            "to" => "required",
            "client_id" => "required",
            "type_id" => "required",
            "price" => "required",
            "toLongitude" => "required",
            "toLatitude" => "required"
        ]);

        $ride = new Ride();
        $ride->fill($request->all());
        $ride->persons = request("places") ?? 1;
        $ride->status_id = Status::where("code", "PEN")->first()->id;
        $ride->save();
        //send notification
        $drivers = User::whereHas('role', function ($query) {
            $query->where('roles.code', 'DRI');
        })->get();
        $found_drivers = [];
        foreach ($drivers as $driver) {
            $driverPosition = array(
                'latitude' => $driver->latitude,
                'longitude' => $driver->longitude
            );
            $distanceBetween = Helper::getDistance($driverPosition['latitude'], $driverPosition['longitude'], $request->input("latitude"), $request->input("longitude"))['kilometers'];
            $distanceBetween = floor($distanceBetween);
            if ($distanceBetween <= $request->distance ?? 15) {
                array_push($found_drivers, $driver->push_token);
            }
        }

        if (count($found_drivers)) {
            $msg = array(
                "body" => $ride->client->name . " demande " . $ride->type->label . " de " . $ride->from . " à " . $ride->to . " pour " . $ride->price . "XAF",
                "title" => "Alerte client",
                "subtitle" => "UCity"
            );
            $fields = array(
                'registration_ids'  => $found_drivers,
                'notification'  => $msg,
                "data" => ["ride_id" => $ride->id]
            );
            $this->notify($fields);
        }
        return response()->json($ride);
    }

    public function terminate($ride_id)
    {
        $ride = Ride::with(["driver.reviews", "client"])->findOrFail($ride_id);
        $ride->status_id = Status::where("code", "TER")->first()->id;
        $ride->save();
        $ride->driver->average = $ride->driver->reviews->avg("note");

        $msg = array(
            "body" => "finished",
            "title" => $ride->type->label . " terminé.",
            "subtitle" => "UCity"
        );

        $fields = array(
            'to'  => $ride->driver->push_token,
            'notification'  => $msg,
            "data" => ["driver" => $ride->driver, "type" => "OVER"]
        );

        $this->notify($fields);

        return response()->json($ride);
    }

    public function show($id)
    {
        $ride = Ride::findOrFail($id);
        return response()->json($ride);
    }

    public function notifyClient($ride_id)
    {
        $ride = Ride::findOrFail($ride_id);
        $ride->status_id = Status::where("code", "ENC")->first()->id;
        $ride->save();
        $msg = array(
            "body" => "Le conducteur " . $ride->driver->name . " vous attend!",
            "title" => "Alerte client",
            "subtitle" => "UCity"
        );
        $fields = array(
            'to'  => $ride->client->push_token,
            'notification'  => $msg,
            "data" => ["ride_id" => $ride->id, "ride" => $ride, "driver" => $ride->driver, "type" => "ARRIVED"]
        );
        $this->notify($fields);
        //transfert de l'argent
        return response()->json($ride);
    }

    public function acceptRide(Request $request, $ride_id)
    {
        $ride = Ride::findOrFail($ride_id);

        if ($ride->driver != null) return response()->json(["message" => "taken"], 400);

        $ride->driver_id = $request->user()->id;
        $ride->status_id = Status::where("code", "VAL")->first()->id;
        $ride->save();

        $msg = array(
            "body" => "Nous avons un conducteur pour vous! Il est sur le chemin.",
            "title" => "Alerte client",
            "subtitle" => "UCity"
        );
        $driver = User::find($request->user()->id);
        $average = $driver->reviews->avg("note");
        $driver->average = $average;
        $ride->driver = $driver;

        $fields = array(
            'to'  => $ride->client->push_token,
            'notification'  => $msg,
            "data" => ["driver" => $ride->driver, "type" => "FOUND"]
        );
        $this->notify($fields);

        return response()->json($ride);
    }

    public function getRidesByDistance(Request $request)
    {
        $lat = request("latitude");
        $lon = request("longitude");
        $distance = request("distance") ?? 15;

        $rides = Ride::with("status")->where("driver_id", null)->get();
        $found_rides = new Collection();

        foreach ($rides as $ride) {
            $clientPosition = array(
                'latitude' => $ride->latitude,
                'longitude' => $ride->longitude
            );
            $distanceBetween = Helper::getDistance($clientPosition['latitude'], $clientPosition['longitude'], $lat, $lon)['kilometers'];
            $ride->distance = round($distanceBetween);
            if ($distanceBetween <= ($request->distance ?? $distance)) {
                $found_rides->add($ride);
            }
        }
        return $found_rides;
    }

    public function getTypes()
    {
        return response()->json(RideType::where("deleted_at", "!=", null)->get());
    }

    public function getAllDriverRides(Request $request)
    {
        return response()->json(Ride::where("driver_id", $request->user()->id)->get());
    }

    public function getAllClientRides(Request $request)
    {
        return response()->json(Ride::where("client_id", $request->user()->id)->get());
    }

    private function notify($fields)
    {
        $headers = array(
            'Authorization: key=AAAAgIEBNOA:APA91bFpq8bLI_Y7diMzKHdV_LolqD0LxMSB2GENkbJvfVl6r9_6evGuoMnD7h53nb1M-_eKseWibWkhSsNHCKs1D0S1zTwK1f0_PXPsl28sAjrF5H3N992roxdg2XCrPhPFl01KjW1S',
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
    }
}
