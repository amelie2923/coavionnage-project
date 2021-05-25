<?php

namespace App\Http\Controllers\Api;

use App\Models\Ad;
use App\Models\Favorite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Notifications\FavoriteNotification;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // public function index(Request $request)
    // {
    //     $ads = Ad::all();

    //     $date = $request->get('date');
    //     if ($date) {
    //         $searchAd = Ad::where('date', '=', $request->get('date'))->get();
    //         // Verif si tableau vide car retourne 200
    //         if (!$searchAd) {
    //             return response()->json(['message' => 'Ad not found'], 403);
    //         }
    //         return response()->json($searchAd);
    //     }
    //     return response()->json($ads);
    // }

    // display latest
    public function index(Request $request)
    {
        $ads = Ad::all()->sortByDesc("created_at")->values();

        $date = $request->get('date');

        if ($date) {
            $searchAd = Ad::where('date', '=', $request->get('date'))->get();
            if (!$searchAd) {
                return response()->json(['message' => 'Ad not found'], 403);
            }
            return response()->json($searchAd);
        }
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
        $fullFileName = $request->file('image')->getClientOriginalName();
        $fileName = pathinfo($fullFileName, PATHINFO_FILENAME);
        $extension = $request->file('image')->getClientOriginalExtension();
        $file = $fileName.'_'.time().'.'.$extension;

        $request->file('image')->storeAs('public/pictures', $file);

        $validator = Validator::make($request->all(), [
            'animal_name' => ['required', 'string'],
            'type_search_id' => ['required', 'integer'],
            'date' => ['required', 'date'],
            'departure_city' => ['required', 'string'],
            'arrival_city' => ['required', 'string'],
            'description' => ['required', 'string'],
            'company' => ['required', 'string'],
            'image' => ['required', 'image'],
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
            'arrival_city' => $request->input('arrival_city'),
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
            return response()->json(['message' => 'Ad not found'], 403);
        }
        return response()->json($ad);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function update(Request $request, $id)
    {
        $ad = Ad::find($id);
            if (!$ad) {
            return response(['message' => 'Id not found'], 404);
        }

        $fullFileName = $request->file('image')->getClientOriginalName();
        $fileName = pathinfo($fullFileName, PATHINFO_FILENAME);
        $extension = $request->file('image')->getClientOriginalExtension();
        $file = $fileName.'_'.time().'.'.$extension;

        $request->file('image')->storeAs('public/pictures', $file);

        $validator = Validator::make($request->all(), [
            'animal_name' => $request->input('animal_name'),
            'type_search_id' => $request->input('type_search_id'),
            'date' => $request->input('date'),
            'departure_city' => $request->input('departure_city'),
            'arrival_city' => $request->input('arrival_city'),
            'description' => $request->input('description'),
            'company' => $request->input('company'),
            'image' => $file,
        ]);

        if ($validator->fails())
        {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $ad->animal_name = $request->input('animal_name');
        $ad->type_search_id = $request->input('type_search_id');
        $ad->date = $request->input('date');
        $ad->departure_city = $request->input('departure_city');
        $ad->arrival_city = $request->input('arrival_city');
        $ad->company = $request->input('company');
        $ad->description = $request->input('description');
        $ad->image = $file;
        $ad->save();

        return response()->json($ad);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $ad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ad $ad)
    {
        $ad->delete();
        return response()->json([
            'message' => 'Ad deleted'
        ]);
    }

    //For notif :
        // auth user id (notifiable_id)
        // user_id
        // ad_id

    public function checkFavorite($id) {
        $ad = Ad::find($id);
        if (!$ad) {
            return response(['message' => 'Ad not found'], 404);
        }
        if(Auth::user()) {
            $favorite = Favorite::where('ad_id', $ad->id)->where('user_id', Auth::user()->id)->first();
            if($favorite) return response()->json(true, 200);
        }
        return response()->json(false, 200);
    }

    public function handleFavorite($id) {
        $ad = Ad::find($id);
        if (!$ad) {
            return response(['message' => 'Ad not found'], 404);
        }
        $favorite = Favorite::where('ad_id', $ad->id)->where('user_id', Auth::user()->id)->first();
        if($favorite) {
            $favorite->delete();
            return response()->json(['success' => 'Favorite deleted'], 200);
        }
        $createFavorite = Favorite::create([
            'ad_id' => $ad->id,
            'user_id' => Auth::user()->id,
        ]);

        $ad->user->notify(new FavoriteNotification($createFavorite));

        return response()->json(['success' => 'Favorite added'], 200);
    }
}
