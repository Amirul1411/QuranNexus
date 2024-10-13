<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\AudioRecitationInfoResource;
use App\Models\AudioRecitationInfo;
use Illuminate\Http\Request;

class APIAudioRecitationInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return AudioRecitationInfoResource::collection(AudioRecitationInfo::all());
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
    // public function store(StoreAudioRecitationInfoRequest $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    public function show(AudioRecitationInfo $audioRecitationInfo, Request $request)
    {

        if ($request->query('audio_info_audio_recitations') === 'true') {
            $audioRecitationInfo->load('audioRecitations');
        }

        return new AudioRecitationInfoResource($audioRecitationInfo);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(AudioRecitationInfo $audioRecitationInfo)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateAudioRecitationInfoRequest $request, AudioRecitationInfo $audioRecitationInfo)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(AudioRecitationInfo $audioRecitationInfo)
    // {
    //     //
    // }
}
