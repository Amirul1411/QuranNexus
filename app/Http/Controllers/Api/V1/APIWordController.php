<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Word;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWordRequest;
use App\Http\Requests\UpdateWordRequest;
use App\Http\Resources\V1\WordResource;
use Illuminate\Http\Request;

class APIWordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return WordResource::collection(Word::all());
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
    // public function store(StoreWordRequest $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    public function show($key)
    {
        $word = Word::where('word_key', $key)->firstOrFail();

        return new WordResource($word);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Word $word)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateWordRequest $request, Word $word)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Word $word)
    // {
    //     //
    // }
}
