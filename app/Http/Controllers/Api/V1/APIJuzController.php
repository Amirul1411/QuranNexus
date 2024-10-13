<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJuzRequest;
use App\Http\Requests\UpdateJuzRequest;
use App\Http\Resources\V1\JuzResource;
use App\Models\Juz;
use Illuminate\Http\Request;

class APIJuzController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return JuzResource::collection(Juz::all());
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
    // public function store(StoreJuzRequest $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    public function show(Juz $juz, Request $request)
    {

        if ($request->query('juz_ayahs') === 'true') {
            $juz->load('ayahs');
        }

        return new JuzResource($juz);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Juz $juz)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateJuzRequest $request, Juz $juz)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Juz $juz)
    // {
    //     //
    // }
}
