<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerify;
use App\Models\Role;
use Carbon\Carbon;
use App\Models\Ride;
use App\Models\Review;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = User::whereHas('role', function ($query) {
            $query->where('roles.code', 'DRI');
        })->where("deleted_at", null)->get();
        return view("drivers.index", compact("drivers"));
    }

    public function store(Request $request) {
        $this->validate($request, [
            "email" => "required|unique:users",
            "name"  => "required",
            "address"   => "required"
        ], [
            "unique" => "L'adresse mail est déjà prise.",
            "required" => "Le champ :field est requis."
        ]);

        $confirmation_code = str_random(4);
        $user = new User();
        $user->fill($request->all());
        $user->confirmation_code = $confirmation_code;
        $user->role_id = Role::where("code", "DRI")->first()->id;
        Mail::to($user->email)->send(new EmailVerify($user, $confirmation_code));
        $user->save();


        return back()->withSuccess("Le compte a bien été créé.");
    }

    public function show($id){
        $driver = User::with(["role", "account"])->findOrFail($id);
        $driver->rides = Ride::where("driver_id", $driver->id);
        $driver->reviews = Review::where("driver_id", $driver->id)->get();
        return view("drivers.show", compact("driver"));
    }

    public function edit(Request $request, $id){
        $driver = User::findOrFail($id);
        return view("drivers.edit", compact("driver"));
    }

    public function destroy($driver_id){
        $driver = User::findOrFail($driver_id);
        $driver->deleted_at = Carbon::now();
        $driver->save();
        return back()->withSuccess("Le conducteur a bien été supprimé.");
    }

    public function toggle($id){
        $driver = User::findOrFail($id);
        $driver->activated = !$driver->activated;
        $driver->save();
        return back()->withSuccess("Le compte du conducteur a été ".$this->getMessage($driver)." avec succès.");
    }

    private function getMessage(User $driver){
        return (!$driver->activated) ? "désactivé" : "réactivé";
    }
}
