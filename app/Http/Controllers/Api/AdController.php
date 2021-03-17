<?php

namespace App\Http\Controllers\Api;

use App\Models\Ad;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return response()->json(Auth::user());
        $fullFileName = $request->file('image')->getClientOriginalName();
        $fileName = pathinfo($fullFileName, PATHINFO_FILENAME);
        $extension = $request->file('image')->getClientOriginalExtension();
        $file = $fileName.'_'.time().'.'.$extension;

        $request->file('image')->storeAs('public/pictures', $file);

        $validator = Validator::make($request->all(), [
            'animal_name' => 'required',
            'type_search_id' => 'required',
            'date' => 'required',
            'departure_city' => 'required',
            'arrival_city' => 'required',
            'description' => 'required',
            'company' => 'required',
            'image' => 'required',
        ]);

        if ($validator->fails())
        {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $ad = Ad::create(([
            'animal_name' => $request->input('animal_name'),
            'type_search_id' => $request->input('type_search_id'),
            'date' => $request->input('date'),
            'departure_city' => $request->input('departure_city'),
            'arrival_city' =>$request->input('arrival_city'),
            'description' => $request->input('description'),
            'company' => $request->input('company'),
            'image' => $file,
            'user_id' => Auth::user()->id,
        ]));
        return response()->json($ad);
    }

   /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ad  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ad = Ad::find($id);
        if(!$ad) {
            return response()->json(['message' => 'Resource not found'], 403);
        }
        return response()->json($ad);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ad  $id
     * @return \Illuminate\Http\Response
     */
    public function update($ad)
    {
        $validator = Validator::make($request->all(), [
            'animal_name' => 'required',
            'type_search_id' => 'required',
            'date' => 'required',
            'departure_city' => 'required',
            'arrival_city' => 'required',
            'description' => 'required',
            'company' => 'required',
            'image' => 'required'
        ]);

        if ($validator->fails())
        {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $ad = Ad::update($request->all());
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

    public function checkFavorite($id) {
        $ad = Ad::find($id);
        if(Auth::user()) {
            $favorite = Favorite::where('ad_id', $ad->id)->where('user_id', Auth::user()->id)->first();
            if($favorite) return response()->json(true, 200);
        }
        return response()->json(false, 200);
    }

    public function handleFavorite($id) {
        $ad = Ad::find($id);
        $favorite = Favorite::where('ad_id', $ad->id)->where('user_id', Auth::user()->id)->first();
        if($favorite) {
            $favorite->delete();
            return response()->json(['success' => 'Favorite deleted'], 200);
        }
        Favorite::create([
            'ad_id' => $ad->id,
            'user_id' => Auth::user()->id
        ]);
        return response()->json(['success' => 'Favorite added'], 200);
    }

}
