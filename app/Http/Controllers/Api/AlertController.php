<?php

namespace App\Http\Controllers\Api;

use App\Models\Alert;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AlertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alerts = Alert::all();
        return response()->json($alerts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'departure_city' => 'required',
            'arrival_city' => 'required',
            'date' => 'required',
        ]);

        if ($validator->fails())
        {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $alert = Alert::create(([
            'date' => $request->input('date'),
            'departure_city' => $request->input('departure_city'),
            'arrival_city' => $request->input('arrival_city'),
            'company' => $request->input('company'),
            'user_id' => Auth::user()->id,
        ]));
        return response()->json($alert);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $alert = Alert::find($id);
        if(!$alert) {
            return response()->json(['message' => 'Alert not found'], 403);
        }
        return response()->json($alert);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Alert  $alert
     * @return \Illuminate\Http\Response
     */
   public function update(Request $request, $id)
    {
        $alert = Alert::find($id);
            if (!$alert) {
            return response(['message' => 'Id not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'departure_city' => 'required',
            'arrival_city' => 'required',
            'company' => 'required',
        ]);

        if ($validator->fails())
        {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $alert->date = $request->input('date');
        $alert->departure_city = $request->input('departure_city');
        $alert->arrival_city = $request->input('arrival_city');
        $alert->company = $request->input('company');
        $alert->save();

        return response()->json($alert);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Alert  $alert
     * @return \Illuminate\Http\Response
     */
        public function destroy(Alert $alert)
    {
        $alert->delete();
        return response()->json([
            'message' => 'Alert deleted'
        ]);
    }
}
