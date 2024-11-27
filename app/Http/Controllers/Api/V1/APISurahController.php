<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Surah;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSurahRequest;
use App\Http\Requests\UpdateSurahRequest;
use App\Http\Resources\V1\SurahResource;
use Illuminate\Http\Request;

class APISurahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return SurahResource::collection(Surah::all());
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
    // public function store(StoreSurahRequest $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    public function show(Surah $surah)
    {
        return new SurahResource($surah);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Surah $surah)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateSurahRequest $request, Surah $surah)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Surah $surah)
    // {
    //     //
    // }
}
