<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Page;

class PageController extends Controller
{
    public function index()
    {
        $allPages = Page::all();

        return $allPages;
    }

    public function show(Page $page)
    {
        return view('recitation', [
            'page' => $page,
        ]);
    }
}
