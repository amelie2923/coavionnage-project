<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect($provider) {
        //redirect to google
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider) {
        // get info from google provider
        $getInfo = Socialite::driver($provider)->user();
        // create new user with infos
        $user = $this->createUser($getInfo, $provider);
        auth()->login($user);
        // redirect to a front-end route to store api_token in storage
        return redirect('http://localhost:3000/login/google/'.$user->api_token);
    }

    // function for create user
    function createUser($getInfo, $provider) {
        // verify if user is in db
        $user = User::where('provider_id', $getInfo->id)->first();
        // if not : create
        if(!$user) {
            $user = User::create([
                'name' => $getInfo->name,
                'email' => $getInfo->email,
                'provider' => $provider,
                'provider_id' => $getInfo->id,
                'api_token' => Str::random(60)
            ]);
        }
        // if : return user
        return $user;
    }
}