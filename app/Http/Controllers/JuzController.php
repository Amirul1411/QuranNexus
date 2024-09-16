<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\V1\APIJuzController;
use App\Http\Controllers\Controller;
use App\Models\Juz;
use Illuminate\Http\Request;

class JuzController extends Controller
{
    public function index()
    {

        $apiJuzController = new APIJuzController();
        $alljuzs = $apiJuzController->index();

        return $alljuzs;
    }

    public function show(Juz $juz)
    {
        $apiJuzController = new APIJuzController();
        $juzResource = $apiJuzController->show($juz);

        $juzModel = $juzResource->resource;

        return view('recitation', [
            'juz' => $juzModel,
        ]);
    }
}
