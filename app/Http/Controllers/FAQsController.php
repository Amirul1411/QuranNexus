<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class FAQsController extends Controller
{
    public function index()
    {
        return view('faqs');
    }
}
