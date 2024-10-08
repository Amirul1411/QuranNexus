<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Ayah;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAyahRequest;
use App\Http\Requests\UpdateAyahRequest;
use App\Http\Resources\V1\AyahResource;
use Illuminate\Http\Request;

class APIAyahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return AyahResource::collection(Ayah::all());
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
    // public function store(StoreAyahRequest $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    public function show($key, Request $request)
    {
        // Split the id string by colon (:)
        [$surah_id, $ayah_index] = explode(':', $key);

        // Now query the Word model using the surah_id and ayah_index
        $ayah = Ayah::where('surah_id', $surah_id)->where('ayah_index', $ayah_index)->firstOrFail();

        // Check if the 'ayahs' query parameter is present and set to 'true'
        if ($request->query('words') === 'true') {
            $ayah->load('words');
        }

        return new AyahResource($ayah);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Ayah $ayah)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateAyahRequest $request, Ayah $ayah)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Ayah $ayah)
    // {
    //     //
    // }
}
