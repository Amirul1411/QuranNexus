<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class APIDocumentationController extends Controller
{
    public function index()
    {
        return view('api-documentation');
    }
}
