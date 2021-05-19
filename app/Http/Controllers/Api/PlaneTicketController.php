<?php

namespace App\Http\Controllers\Api;

use App\Models\PlaneTicket;
use Illuminate\Http\Request;
use App\Models\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Notifications\AlertNotification;

class PlaneTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $planeTickets = PlaneTicket::all();
        $date = $request->get('date');
        if ($date) {
            $searchFlight = PlaneTicket::where('date', '=', $request->get('date'))->get();
            // Verif si tableau vide car retourne 200
            if (!$searchFlight) {
                return response()->json(['message' => 'Planeticket not found'], 403);
            }
            return response()->json($searchFlight);
        }
        return response()->json($planeTickets);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request-> all(), [
            'date' => 'required',
            'departure_city' => 'required',
            'arrival_city' => 'required',
            'description' => 'required',
            'company' => 'required',
        ]);
        if ($validator->fails())
        {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $planeTicket = PlaneTicket::create(([
            'date' => $request->input('date'),
            'departure_city' => $request->input('departure_city'),
            'arrival_city' =>$request->input('arrival_city'),
            'description' => $request->input('description'),
            'company' => $request->input('company'),
            'user_id' => Auth::user()->id,
        ]));

        //send alert notif here

        // $alert = Alert::where('date', '=', $request->input('date'),'departure_city', '=', $request->input('departure_city'), 'arrival_city', '=', $request->input('arrival_city'), 'company', '=', $request->input('company')->get());

        if($planeTicket && $alert) {
            //send notiif
            $alert->user->notify(new AlertNotification($planeTicket));
        }

        return response()->json($planeTicket);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $planeTicket = PlaneTicket::find($id);
        if(!$planeTicket) {
            return response()->json(['message' => 'Resource not found'], 403);
        }
        return response()->json($planeTicket);
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
        $planeTicket = PlaneTicket::find($id);
            if (!$planeTicket) {
            return response(['message' => 'Id not found'], 404);
        }
        $validator = Validator::make($request-> all(), [
            'user_id' => 'required',
            'date' => 'required',
            'departure_city' => 'required',
            'arrival_city' => 'required',
            'description' => 'required',
            'company' => 'required',
        ]);
        if ($validator->fails())
        {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $planeTicket->date = $request->input('date');
        $planeTicket->departure_city = $request->input('departure_city');
        $planeTicket->arrival_city = $request->input('arrival_city');
        $planeTicket->company = $request->input('company');
        $planeTicket->description = $request->input('description');
        $planeTicket->save();

        return response()->json($planeTicket);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PlaneTicket $id)
    {
        $planeTicket->delete();
        return response()->json([
            'message' => 'Plane Ticket deleted'
        ]);
    }
}
