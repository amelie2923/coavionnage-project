<?php

namespace App\Http\Controllers\Api;

use App\Models\TypeSearch;
use Illuminate\Http\Request;

class TypeSearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $typesearchs = TypeSearch::all();
        return response()->json($typesearchs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TypeSearch  $typeSearch
     * @return \Illuminate\Http\Response
     */
    public function show(TypeSearch $typeSearch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TypeSearch  $typeSearch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TypeSearch $typeSearch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TypeSearch  $typeSearch
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypeSearch $typeSearch)
    {
        //
    }
}
