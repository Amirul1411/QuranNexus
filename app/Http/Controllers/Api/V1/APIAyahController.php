<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Ayah;
use App\Models\Surah;
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
    public function show($key)
    {
        $ayah = Ayah::where('ayah_key', $key)->firstOrFail();
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
    public function getVersesByChapter($chapterId, Request $request)
    {
        $ayahs = Ayah::where('surah_id', $chapterId)->with(['words', 'translations'])->get();
        return AyahResource::collection($ayahs);
    }
}
