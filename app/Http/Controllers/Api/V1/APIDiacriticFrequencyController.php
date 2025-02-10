<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\DiacriticFrequencyResource;
use App\Models\DiacriticFrequency;

class APIDiacriticFrequencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return DiacriticFrequencyResource::collection(DiacriticFrequency::all());
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
    // public function store(StoreDiacriticFrequencyRequest $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    public function show(DiacriticFrequency $diacriticFrequency)
    {
        return new DiacriticFrequencyResource($diacriticFrequency);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(DiacriticFrequency $diacriticFrequency)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateDiacriticFrequencyRequest $request, DiacriticFrequency $diacriticFrequency)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(DiacriticFrequency $diacriticFrequency)
    // {
    //     //
    // }
}
