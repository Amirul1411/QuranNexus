<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\SurahInfoResource;
use App\Models\SurahInfo;
use Illuminate\Http\Request;

class APISurahInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return SurahInfoResource::collection(SurahInfo::all());
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
    // public function store(StoreSurahInfoRequest $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    public function show(SurahInfo $surahInfo)
    {
        return new SurahInfoResource($surahInfo);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(SurahInfo $surahInfo)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateSurahInfoRequest $request, SurahInfo $surahInfo)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(SurahInfo $surahInfo)
    // {
    //     //
    // }
}
