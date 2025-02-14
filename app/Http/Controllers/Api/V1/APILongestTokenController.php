<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\LongestTokenResource;
use App\Models\LongestToken;

class APILongestTokenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return LongestTokenResource::collection(LongestToken::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(StoreLongestTokenRequest $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    public function show(LongestToken $longestToken)
    {
        return new LongestTokenResource($longestToken);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(LongestToken $longestToken)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateLongestTokenRequest $request, LongestToken $longestToken)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(LongestToken $longestToken)
    // {
    //     //
    // }
}
