<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AboutController extends Controller
{
    /**
     * Display the about page with biodata.
     */
    public function index(): View
    {
        return view('about');
    }
}
