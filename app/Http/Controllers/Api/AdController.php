<?php

namespace App\Http\Controllers\Api;

use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Ad::all();
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
            'type_search_id' => 'required',
            'date' => 'required',
            'departure_city' => 'required',
            'arrival_city' => 'required',
            'number_animals' => 'required',
            'description' => 'required',
            'company' => 'required',
        ]);

        if ($validator->fails())
        {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        Ad::create($request->all());
    }

   /**
     * Display the specified resource.
     *
     * @param  \App\Models\Add  $ad
     * @return \Illuminate\Http\Response
     */
    public function show(Ad $ad)
    {
        return $ad;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ad $ad)
    {
        $validator = Validator::make($request->all(), [
            'type_search_id' => 'required',
            'date' => 'required',
            'departure_city' => 'required',
            'arrival_city' => 'required',
            'number_animals' => 'required',
            'description' => 'required',
            'company' => 'required',
        ]);

        if ($validator->fails())
        {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $ad->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ad $ad)
    {
        $ad->delete();
    }
}
