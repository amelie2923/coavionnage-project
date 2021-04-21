<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Validation\LoginValidation;
use App\Http\Validation\RegisterValidation;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;


class AuthController extends BaseController
{
    /**
     * Register user api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request, RegisterValidation $validation) {
        $validator = Validator::make($request->all(), $validation->rules(), $validation->messages());

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $user = User::create([
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'password' => bcrypt($request->input('password')),
            'api_token' => Str::random(60),
            'role_id' => 2,
        ]);

        return response()->json($user);
    }

        /**
     * Register asso api
     *
     * @return \Illuminate\Http\Response
     */
    public function registerAssociation(Request $request, RegisterValidation $validation) {
        $validator = Validator::make($request->all(), $validation->rules(), $validation->messages());

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $user = User::create([
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'password' => bcrypt($request->input('password')),
            'api_token' => Str::random(60),
            'role_id' => 1,
        ]);

        return response()->json($user);
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(request $request, LoginValidation $validation) {

        $validator = Validator::make($request->all(), $validation->rules(), $validation->messages());

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        if(Auth::attempt([ 'email' => $request->input('email'), 'password' => $request->input('password')])) {
            $user = User::where('email', $request->input('email'))->firstOrFail();
            return response()->json($user);
        } else {
            return response()->json(['errors' => 'bad_credentials'], 401);
        }
    }

    /**
     * Forgot password api
     *
     * @return \Illuminate\Http\Response
     */
    protected function sendResetLinkResponse(Request $request)
    {
        $input = $request->only('email');
        $validator = Validator::make($input, [
            'email' => "required|email"
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $response =  Password::sendResetLink($input);
        if($response == Password::RESET_LINK_SENT){
            $message = "Mail send successfully";
        } else{
        $message = "Email could not be sent to this email address";
        }
        //$message = $response == Password::RESET_LINK_SENT ? 'Mail sendsuccessfully' : GLOBAL_SOMETHING_WANTS_TO_WRONG;
        $response = ['data'=>'','message' => $message];
        return response($response, 200);
    }
    /**
     * Reset password api
     *
     * @return \Illuminate\Http\Response
     */

    protected function sendResetResponse(Request $request)
    {
        //password.reset
        $input = $request->only('email','token', 'password', 'password_confirmation');
        $validator = Validator::make($input, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $response = Password::reset($input, function ($user, $password) {
        $user->forceFill([
            'password' => Hash::make($password)
        ])->save();
        //$user->setRememberToken(Str::random(60));
        event(new PasswordReset($user));
        });
        if($response == Password::PASSWORD_RESET){
            $message = "Password reset successfully";
        }else{
            $message = "Email could not be sent to this email address";
        }
        $response = ['data'=>'','message' => $message];
        return response()->json($response);
    }

    /** To do -> add remember me function */

    /**
     * Logout api
     *
     * @return \Illuminate\Http\Response
     */
    public function logout (Request $request) {
        if (Auth::user()) {
            $user = Auth::user();
            $user->api_token = null; // clear api token
            $user->save();
        }
        return response()->json(['message' => 'You have been successfully logout'], 200);
    }
}