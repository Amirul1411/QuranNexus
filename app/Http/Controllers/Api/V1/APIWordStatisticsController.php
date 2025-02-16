<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\WordStatisticsResource;
use App\Models\WordStatistics;
use Illuminate\Http\Request;

class APIWordStatisticsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return WordStatisticsResource::collection(WordStatistics::all());
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
    // public function store(StoreWordStatisticsRequest $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    public function show(WordStatistics $wordStatistics, Request $request)
    {
        return new WordStatisticsResource($wordStatistics);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(WordStatistics $wordStatistics)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateWordStatisticsRequest $request, WordStatistics $wordStatistics)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(WordStatistics $wordStatistics)
    // {
    //     //
    // }
}
