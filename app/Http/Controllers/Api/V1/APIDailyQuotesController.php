<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\DailyQuotesResource;
use App\Models\DailyQuotes;

class APIDailyQuotesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return DailyQuotesResource::collection(DailyQuotes::all());
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
    // public function store(StoreDailyQuotesRequest $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    public function show(DailyQuotes $dailyQuotes, Request $request)
    {
        return new DailyQuotesResource($dailyQuotes);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(DailyQuotes $dailyQuotes)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateDailyQuotesRequest $request, DailyQuotes $dailyQuotes)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(DailyQuotes $dailyQuotes)
    // {
    //     //
    // }
}
