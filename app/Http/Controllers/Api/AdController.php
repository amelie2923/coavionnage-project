<?php

namespace App\Http\Controllers\Api;

use App\Models\Ad;
use Illuminate\Http\Request;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ads = Ad::all();
        return response()->json($ads);
        return $this->sendResponse(AdResource::collection($ads), 'Ads retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'type_search_id' => 'required',
            'date' => 'required',
            'departure_city' => 'required',
            'arrival_city' => 'required',
            'number_animals' => 'required',
            'description' => 'required',
            'company' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $ad = Ad::create($input);

        return $this->sendResponse(new AdResource($ad), 'Ad created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ad = Ad::find($id);

        if (is_null($ad)) {
            return $this->sendError('Ad not found.');
        }

        return $this->sendResponse(new ProductResource($product), 'Product retrieved successfully.');
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
        $input = $request->all();

        $validator = Validator::make($input, [
            'type_search_id' => 'required',
            'date' => 'required',
            'departure_city' => 'required',
            'arrival_city' => 'required',
            'number_animals' => 'required',
            'description' => 'required',
            'company' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $ad->type_search_id = $input['type_search_id'];
        $ad->date = $input['date'];
        $ad->departure_city = $input['departure_city'];
        $ad->arrival_city = $input['arrival_city'];
        $ad->number_animals = $input['number_animals'];
        $ad->description = $input['description'];
        $ad->company = $input['company'];
        $ad->save();

        return $this->sendResponse(new AdResource($ad), 'Ad updated successfully.');
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

        return $this->sendResponse([], 'Ad deleted successfully.');
    }
}
