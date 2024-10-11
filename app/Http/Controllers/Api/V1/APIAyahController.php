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

        $ayah = Ayah::where('ayah_key', $key)->firstOrFail();

        if ($request->query('words') === 'true') {
            $ayah->load('words');
        }

        if ($request->query('tafseers') === 'true') {
            $ayah->load('tafseers');
        }

        if ($request->query('translations') === 'true') {
            $ayah->load('translations');
        }

        if ($request->query('audio_recitations') === 'true') {
            $ayah->load('audioRecitations');
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
