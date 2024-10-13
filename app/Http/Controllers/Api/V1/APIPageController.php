<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Http\Resources\V1\PageResource;
use App\Models\Page;
use Illuminate\Http\Request;

class APIPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PageResource::collection(Page::all());
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
    // public function store(StorePageRequest $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    public function show(Page $page, Request $request)
    {

        if ($request->query('page_ayahs') === 'true') {
            $page->load('ayahs');
        }

        return new PageResource($page);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Page $page)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdatePageRequest $request, Page $page)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Page $page)
    // {
    //     //
    // }
}
