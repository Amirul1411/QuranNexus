<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\AudioRecitationResource;
use App\Models\AudioRecitation;
use Illuminate\Http\Request;

class APIAudioRecitationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return AudioRecitationResource::collection(AudioRecitation::all());
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
    // public function store(StoreAudioRecitationRequest $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    public function show($key)
    {
        $audioRecitation = AudioRecitation::where('ayah_key', $key)->get();

        return AudioRecitationResource::collection($audioRecitation);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(AudioRecitation $audioRecitation)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateAudioRecitationRequest $request, AudioRecitation $audioRecitation)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(AudioRecitation $audioRecitation)
    // {
    //     //
    // }
}
