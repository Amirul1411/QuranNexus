<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\V1\APIPageController;
use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {

        $apiPageController = new APIPageController();
        $allPages = $apiPageController->index();

        return $allPages;
    }

    public function show(Page $page)
    {
        $apiPageController = new APIPageController();
        $pageResource = $apiPageController->show($page);

        $pageModel = $pageResource->resource;

        return view('livewire.recitation-by-page','recitation', [
            'page' => $pageModel,
        ]);
    }
}
