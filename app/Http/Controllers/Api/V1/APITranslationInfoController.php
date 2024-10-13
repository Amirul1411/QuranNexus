<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TranslationInfoResource;
use App\Models\TranslationInfo;
use Illuminate\Http\Request;

class APITranslationInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TranslationInfoResource::collection(TranslationInfo::all());
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
    // public function store(StoreTranslationInfoRequest $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    public function show(TranslationInfo $translationInfo, Request $request)
    {

        if ($request->query('translation_info_translations') === 'true') {
            $translationInfo->load('translations');
        }

        return new TranslationInfoResource($translationInfo);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(TranslationInfo $translationInfo)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateTranslationInfoRequest $request, TranslationInfo $translation)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(TranslationInfo $translationInfo)
    // {
    //     //
    // }
}
