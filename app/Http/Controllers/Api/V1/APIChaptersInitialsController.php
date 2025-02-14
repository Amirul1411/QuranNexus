<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ChaptersInitialsResource;
use App\Models\ChaptersInitials;

class APIChaptersInitialsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ChaptersInitialsResource::collection(ChaptersInitials::all());
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
    // public function store(StoreChaptersInitialsRequest $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    public function show(ChaptersInitials $chaptersInitials)
    {
        return new ChaptersInitialsResource($chaptersInitials);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(ChaptersInitials $chaptersInitials)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateChaptersInitialsRequest $request, ChaptersInitials $chaptersInitials)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(ChaptersInitials $chaptersInitials)
    // {
    //     //
    // }
}
