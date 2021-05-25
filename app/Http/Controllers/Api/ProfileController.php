<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $user = Auth::user();
        $validator = Validator::make($request-> all(), [
            'address' => 'required',
            'phone' => 'required',
        ]);
        if ($validator->fails())
        {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $profile = Profile::create(([
            'user_id' => Auth::user()->id,
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
        ]));
        // $profile = User::where('id', $user->id)->first();
        // if(!$profile) {
        //     return response()->json(['message' => 'Profile not found'], 403);
        // }
        return response()->json($profile);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $profile = Profile::find($id);
        // $profile = User::where('id', $user->id)->first();
        // $token = $request->header('API-TOKEN');
        // $profile = User::where('api_token', $token)->first();
        if(!$profile) {
            return response()->json(['message' => 'Profile not found'], 403);
        }
        return response()->json($profile);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
