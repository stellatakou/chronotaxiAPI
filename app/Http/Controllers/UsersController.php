<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\Account;
use App\Models\Role;

class UsersController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
            'password_confirmation' => 'required|string'
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'role_id' => Role::where("code", "CLI")->first()->id
        ]);
        $user->save();
        $account = new Account();
        $account->user_id = $user->id;
        $account->sold = 0;
        $account->save();
        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }

    // public function asher(){
    //     $user = User::where('name','Stella')->first();
    //     $user->password = bcrypt($user->password);
    //     $user->save();
    //     dd($user->password);
    // }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'email ou mot de passe incorrect!'
            ], 401);

        $user = $request->user();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me) $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'user' => $user,
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        try{
            //$request->user()->token()->revoke();
            auth()->logout();
        }catch(\Exception $e){ }
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'email' => 'unique:users,email,' . $id
        ]);

        $user = User::findOrFail($id);
        $user->update($request->all());
        return response()->json([
            "message" => "Informations mises à jour."
        ]);
    }

    public function sold(Request $request)
    {
        return $request->user()->account->sold;
    }

    public function updateToken(Request $request)
    {
        $this->validate($request, [
            "push_token" => "required|string",
            "user_id" => "required",
        ]);

        $user = User::find(request("user_id"));
        $user->push_token = request()->input("push_token");
        $user->save();
        return response()->json($user);
    }

    public function register(Request $request){
        $this->validate($request, [
            "email" => "required|email|unique:users",
            "password" => "required",
            "phone" => "required"
        ]);

        $user = new User();
        $user->fill($request->all());
        $user->role_id = Role::where("code", "CLI")->first()->id;

        $password = bcrypt($user->password);

        $user->password = $password;
        $user->save();
        return response()->json($user);
    }
}
