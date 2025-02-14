<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CharacterFrequencyResource;
use App\Models\CharacterFrequency;

class APICharacterFrequencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CharacterFrequencyResource::collection(CharacterFrequency::all());
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
    // public function store(StoreCharacterFrequencyRequest $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    public function show(CharacterFrequency $characterFrequency)
    {
        return new CharacterFrequencyResource($characterFrequency);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(CharacterFrequency $characterFrequency)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateCharacterFrequencyRequest $request, CharacterFrequency $characterFrequency)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(CharacterFrequency $characterFrequency)
    // {
    //     //
    // }
}
