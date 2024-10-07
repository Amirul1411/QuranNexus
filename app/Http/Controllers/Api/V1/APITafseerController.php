<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TafseerResource;
use App\Models\Tafseer;
use Illuminate\Http\Request;

class APITafseerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TafseerResource::collection(Tafseer::all());
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
    // public function store(StoreTafseerRequest $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Split the id string by colon (:)
        [$surah_id, $ayah_index] = explode(':', $id);

        // Now query the Word model using the surah_id, ayah_index, and word_index
        $tafseer = Tafseer::where('surah_id', $surah_id)->where('ayah_index', $ayah_index)->firstOrFail();

        // Return the Word resource
        return new TafseerResource($tafseer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Tafseer $tafseer)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateTafseerRequest $request, Tafseer $tafseer)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Tafseer $tafseer)
    // {
    //     //
    // }
}
