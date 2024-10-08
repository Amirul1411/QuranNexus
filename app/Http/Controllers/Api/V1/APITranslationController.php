<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTranslationRequest;
use App\Http\Requests\UpdateTranslationRequest;
use App\Http\Resources\V1\TranslationResource;
use App\Models\Translation;
use Illuminate\Http\Request;

class APITranslationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TranslationResource::collection(Translation::all());
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
    // public function store(StoreTranslationRequest $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    public function show($key)
    {
        // Split the id string by colon (:)
        [$surah_id, $ayah_index] = explode(':', $key);

        // Now query the Word model using the surah_id and ayah_index
        $translation = Translation::where('surah_id', $surah_id)->where('ayah_index', $ayah_index)->firstOrFail();

        return new TranslationResource($translation);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Translation $translation)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateTranslationRequest $request, Translation $translation)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Translation $translation)
    // {
    //     //
    // }
}
