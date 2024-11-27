<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TafseerInfoResource;
use App\Models\TafseerInfo;
use Illuminate\Http\Request;

class APITafseerInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TafseerInfoResource::collection(TafseerInfo::all());
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
    // public function store(StoreTafseerInfoRequest $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    public function show(TafseerInfo $tafseerInfo)
    {
        return new TafseerInfoResource($tafseerInfo);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(TafseerInfo $tafseerInfo)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateTafseerInfoRequest $request, TafseerInfo $tafseerInfo)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(TafseerInfo $tafseerInfo)
    // {
    //     //
    // }
}
