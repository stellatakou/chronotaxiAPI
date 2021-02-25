<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UsersController extends Controller
{
    public function login(Request $request)
    {
        $email = request("email");
        $password = request("password");
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            if(auth()->user()->role->code != "SAD" && auth()->user()->role->code != "ADM"){
                auth()->logout();
                return back()->withErrors([
                    "message" => "Vous n'êtes pas autorisé à accéder à cette interface."
                ]);
            }
            return redirect(route("home"));
        }else{
            return back()->withErrors([
                "message" => "Email ou mot de passe incorrect!"
            ]);
        }
    }

    public function index(){
        $users = User::whereHas('role', function ($query) {
            $query->where('roles.code', 'ADM');
        })->where("activated", "1")->get();
        return view("users.index", compact("users"));
    }

    public function logout(){
        auth()->logout();
        return redirect(route("login"));
    }
}
