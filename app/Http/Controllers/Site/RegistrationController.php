<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordEmail;

class RegistrationController extends Controller
{

    public function confirm($confirmation_code)
    {
        if (!$confirmation_code) {
            throw new InvalidConfirmationCodeException;
        }

        $user = User::whereConfirmationCode($confirmation_code)->first();

        if (!$user) {
            abort(404, "Le code ne correspond à aucun utilisateur.");
        }

        $user->confirmed = 1;
        $user->confirmation_code = null;

        $password = str_random(10);
        $user->password = bcrypt($password);

        $user->save();

        Mail::to($user->email)->send(new PasswordEmail($user, $password));

        return redirect()->route('login')->withSuccess("Votre compte a bien été activé!");
    }
}
